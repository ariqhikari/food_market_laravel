<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'picture_path' => ['required', 'image'],
            'description' => ['required', 'string'],
            'ingredients' => ['required', 'string'],
            'price' => ['required', 'integer'],
            'rate' => ['required', 'numeric'],
            'types' => ['required', 'string'],
        ]);

        $data = $request->all();

        $data['picture_path'] = $request->file('picture_path')->store('assets/food', 'public');

        Food::create($data);

        return redirect()->route('food.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  Food $food
     * @return App\Models\Food;
     */
    public function show(Food $food)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Food $food
     * @return App\Models\Food;
     */
    public function edit(Food $food)
    {
        return view('food.edit', [
            'food' => $food
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Food $food
     * @return App\Models\Food;
     */
    public function update(Request $request, Food $food)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:food,name,' . $food->id],
            'picture_path' => ['image'],
            'description' => ['required', 'string'],
            'ingredients' => ['required', 'string'],
            'price' => ['required', 'integer'],
            'rate' => ['required', 'numeric'],
        ]);

        $data = $request->all();

        if ($request->file('picture_path')) {
            Storage::disk('public')->delete($food->picture_path);
            $data['picture_path'] = $request->file('picture_path')->store('assets/food', 'public');
        }

        $food->update($data);

        return redirect()->route('food.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Food $food
     * @return App\Models\Food;
     */
    public function destroy(Food $food)
    {
        Storage::disk('public')->delete($food->picture_path);
        $food->delete();

        return redirect()->route('food.index');
    }
}
