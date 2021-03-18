<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Actions\Fortify\PasswordValidationRules;

class UserController extends Controller
{
    use PasswordValidationRules;

    public function login(Request $request) {
        try {
            // buat validasi request
            $request->validate([
                'email' => 'email|required',
                'password' => 'required'
            ]);

            // cek credentials
            $credentials = request(['email', 'password']);
            if(!Auth::attempt($credentials)) {
                return ResponseFormatter::error([
                    'message' => 'Unauthorized'
                ], 'Authentication Failder', 500);
            }

            // cek password, jika gagal maka throw error
            $user = User::where('email', $request->email)->first();
            if(!Hash::check($request->password, $user->password)) {
                throw new \Exeption('Invalid Password');
            }

            // jika password benar maka login dan beri user token akses
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return ResponseFormatter::success([
                'message' => 'Login Success',
                'access_token' => $tokenResult,
                'token-type' => 'Bearer',
                'user' => $user
            ], 'Authenticated');
            
        } catch(Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Wrong',
                'error' => $error
            ], 'Authentication Failed', 500);
        }
    }

    public function register(Request $request) {
        try {
            // validasi yang benar
            $rules = [
                'name' => 'required|string|max:255',
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => $this->passwordRules()
            ];

            $validator = Validator::make($request->all(), $rules);

            // create data to database
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'houseNumber' => $request->houseNumber,
                'phoneNumber' => $request->phoneNumber,
                'city' => $request->city,
                'password' => Hash::make($request->password)
            ]);

            // get data user 
            $user = User::where('email', $request->email)->first();

            // create tokec access
            $tokenResult = $user->createToken('authToken')->plainTextToken;

            // send response
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'User Resgitered');

        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Authentication Failed', 500);
        }
    }

    public function logout(Request $request) {
        // get token dari user yang sedang aktif lalu hapus token
        $token = $request->user()->currentAccessToken()->delete();

        return ResponseFormatter::success($token, 'Token Revoked');
    }

    public function updateProfile(Request $request) {
        $data = $request->all();

        if(isset($request['password'])) {
            $data['password'] = Hash::make($request->input('password'));
        }
        
        // get data user active
        $user = Auth::user();

        // update data ke tabel user
        $user->update($data);

        return ResponseFormatter::success($user, 'Profile Updated');
    }

    public function fetch(Request $request) {
        return ResponseFormatter::success($request->user(), 'Data profile berhasil diambil');
    }

    public function updatePhoto(Request $request) {
        // validate file upload
        $validator = Validator::make($request->all(), [
            'file' => 'required|image|max:2048'
        ]);

        // cek jika validate gagal
        if($validator->fails()) {
            return ResponseFormatter::error([
                'error' => $validator->errors()
            ], 'Update photo fails', 401);
        }

        // cek photo yang diupload ada atau tidak
        if($request->file('file')) {
            // simpan file ke folder yang diinginkan
            $file = $request->file->store('assets/user', 'public');

            // get data user untuk update photo 
            $user = Auth::user();

            // get data url dari file
            $user->profile_photo_path = $file;

            // update database
            $user->update();

            return ResponseFormatter::success([$file], 'File successfully uploaded');
        }

    }

}
