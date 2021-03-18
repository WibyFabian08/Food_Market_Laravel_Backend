<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;
use App\Http\Requests\FoodRequest;
use Illuminate\Support\Facades\File;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $foods = Food::paginate(10);

        return view('food.index', [
            'foods' => $foods
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('food.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FoodRequest $request)
    {
        $data = $request->all();

        $data['picturePath'] = $request->file('picturePath')->store('assets/food', 'public');

        Food::create($data);

        return redirect()->route('food.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $food = Food::findOrFail($id);

        return view('food/edit', [
            'food' => $food
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FoodRequest $request, $id)
    {
        $data = $request->all();

        $food = Food::findOrFail($id);

        $image = $food->picturePath;

        $array = explode('/', ltrim($image, '/'));
        
        $path = 'storage/assets/food/';

        if($request->file('picturePath')) {
            File::delete($path.end($array));
            $data['picturePath'] = $request->file('picturePath')->store('assets/food', 'public');
        }

        $food->update($data);

        return redirect()->route('food.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $food = Food::findOrFail($id);

        $image = $food->picturePath;

        $array = explode('/', ltrim($image, '/'));
        
        $path = 'storage/assets/food/';

        File::delete($path.end($array));

        $food->delete();

        return redirect()->route('food.index');
    }
}
