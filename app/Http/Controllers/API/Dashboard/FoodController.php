<?php

namespace App\Http\Controllers\API\Dashboard;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Food;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $foods = Food::latest()->get();
        return ResponseFormatter::success($foods, 'Data list food berhasil diambil');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'picture_path' => ['required', 'image'],
            'description' => ['required', 'string'],
            'ingredients' => ['required', 'string'],
            'price' => ['required', 'integer'],
            'rate' => ['required', 'numeric'],
            'types' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $validator->errors(),
            ], 'Store Food Failed', 500);
        }

        try {
            $data = $request->all();
            $data['picture_path'] = $request->file('picture_path')->store('assets/food', 'public');

            $food = Food::create($data);

            return ResponseFormatter::success($food, 'Data food ditambah');
        } catch (QueryException $e) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $e->errorInfo,
            ], 'Query Exception', 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Food  $food
     * @return \Illuminate\Http\Response
     */
    public function show(Food $food)
    {
        return ResponseFormatter::success($food, 'Data food berhasil diambil');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Food  $food
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Food $food)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:food,name,' . $food->id],
            'picture_path' => ['image'],
            'description' => ['required', 'string'],
            'ingredients' => ['required', 'string'],
            'price' => ['required', 'integer'],
            'rate' => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $validator->errors(),
            ], 'Store Food Failed', 500);
        }

        try {
            $data = $request->all();

            if ($request->file('picture_path')) {
                Storage::disk('public')->delete($food->picture_path);
                $data['picture_path'] = $request->file('picture_path')->store('assets/food', 'public');
            }

            $food->update($data);

            return ResponseFormatter::success($food, 'Data food berhasil diupdate');
        } catch (QueryException $e) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $e->errorInfo,
            ], 'Query Exception', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Food  $food
     * @return \Illuminate\Http\Response
     */
    public function destroy(Food $food)
    {
        Storage::disk('public')->delete($food->picture_path);
        $food->delete();

        return ResponseFormatter::success(null, 'Data food berhasil dihapus');
    }
}
