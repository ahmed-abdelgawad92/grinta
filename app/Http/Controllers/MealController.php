<?php

namespace App\Http\Controllers;

use App\Meal;
use Illuminate\Http\Request;

class MealController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $meals = Meal::all();
        return view('meal.all', ['active' => 'meal', 'meals' => $meals]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('auth');
        return view('meal.add', ['active' => 'createMeal']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('auth');
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'price' => 'required|numeric'
        ]);

        $meal = new Meal;
        $meal->name = $request->name;
        $meal->category = $request->category;
        $meal->ingredients = $request->ingredients;
        $meal->price = $request->price;

        $saved = $meal->save();
        if (!$saved) {
            return redirect()->back()->with(['error' => 'Something went wrong on server , please try again!']);
        }
        return redirect()->back()->with(['success' => 'The meal "' . $meal->name . '" created successfully']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('auth');
        $meal = Meal::findOrFail($id);
        return view('meal.edit', ['active' => 'meal', 'meal' => $meal]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $meal)
    {
        $this->authorize('auth');
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'price' => 'required|numeric'
        ]);

        $meal = Meal::findOrFail($meal);
        $meal->name = $request->name;
        $meal->category = $request->category;
        $meal->ingredients = $request->ingredients;
        $meal->price = $request->price;

        $saved = $meal->save();
        if (!$saved) {
            return redirect()->back()->with(['error' => 'Something went wrong on server , please try again!']);
        }
        return redirect()->back()->with(['success' => 'The meal "' . $meal->name . '" edited successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function destroy($meal)
    {
        $this->authorize('auth');
        $meal = Meal::findOrFail($meal);
        $deleted = $meal->delete();
        if (!$deleted) {
            return redirect()->back()->with(['error' => 'Something went wrong on server, please try again!']);
        }
        return redirect()->back()->with(['success' => 'The meal "' . $meal->name . '" deleted successfully']);
    }
}
