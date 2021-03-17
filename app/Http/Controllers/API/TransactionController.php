<?php

namespace App\Http\Controllers\API;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\TransactionRequest;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function all(Request $request) {
        $id = $request->input('id');
        $limit = $request->input('limit', 6);
        $food_id = $request->input('food_id');
        $status = $request->input('status');

        if($id) {
            $transaction = Transaction::with(['food', 'user'])->find($id);

            if($transaction) {
                return ResponseFormatter::success([
                    $transaction
                ], 'Data transaksi berhasil didapat');
            } else {
                return ResponseFormatter::erro([
                    null
                ], 'Data tidak ditemukan', 404);
            }
        }

        $transaction = Transaction::with(['food', 'user'])->where('user_id', Auth::user()->id);

        if($food_id) {
            $transaction->where('food_id', $food_id);
        }

        if($status) {
            $transaction->where('status', $status);
        }

        return ResponseFormatter::success([
            $transaction->paginate($limit)
        ], 'Data list transaksi berhasil didapat');
    }

    public function update(Request $request, $id) {
        // get data by id
        $transaction = Transaction::findOrFail($id);

        $transaction->update($request->all());

        return ResponseFormatter::success([
            $transaction
        ], 'Transaksi berhasil diupdate');
    }

    public function checkout(TransactionRequest $request) {
        // insert data chackout
        $transaction = Transaction::create([
            'food_id' => $request->food_id,
            'user_id' => $request->user_id,
            'quantity' => $request->quantity,
            'total' => $request->total,
            'status' => $request->status,
            'payment_url' => ''
        ]);

        // configurasi midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // panggil transaction yang tadi dibuat
        $transaction = Transaction::with(['food', 'user'])->find($transaction->id);

        // buat transaksi midtrans
        $midtrans = array(
            'transaction_details' => array(
                'order_id' => $transaction->id,
                'gross_amount' => (int) $transaction->total,
            ),
            'customer_details' => array(
                'first_name' => $transaction->user->name,
                'email' => $transaction->user->email,
            ),
            'enabled_payments' => array('gopay', 'bank_transfer'),
            'vtweb' => array()
        );

        // memanggil midtrans
        try {
            // get payment url
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;

            // update data transaksi
            $transaction->payment_url = $paymentUrl;
            $transaction->save();

            // kirm response
            return ResponseFormatter::success($transaction, 'Transaksi berhasl'); 

        } catch (Exceptions $e) {
            return ResponseFormatter::error($e->getMessage(), 'Transaksi gagal');
        }
    }
    
}
