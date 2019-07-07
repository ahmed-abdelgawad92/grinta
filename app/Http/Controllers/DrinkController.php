<?php

namespace App\Http\Controllers;

use App\Drink;
use Illuminate\Http\Request;

class DrinkController extends Controller
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
        $this->authorize('auth');
        $drinks = Drink::all();
        return view('drink.all', ['active' => 'drink', 'drinks' => $drinks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('auth');
        return view('drink.add', ['active' => 'createDrink']);
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

        $drink = new Drink;
        $drink->name = $request->name;
        $drink->category = $request->category;
        $drink->ingredients = $request->ingredients;
        $drink->price = $request->price;

        $saved = $drink->save();
        if (!$saved) {
            return redirect()->back()->with(['error' => 'Something went wrong on server , please try again!']);
        }
        return redirect()->back()->with(['success' => 'The drink "' . $drink->name . '" created successfully']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Drink  $drink
     * @return \Illuminate\Http\Response
     */
    public function edit($drink)
    {
        $this->authorize('auth');
        $drink = Drink::findOrFail($drink);
        return view('drink.edit', ['active' => 'drink' , 'drink' => $drink]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Drink  $drink
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $drink)
    {
        $this->authorize('auth');
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'price' => 'required|numeric'
        ]);

        $drink = Drink::findOrFail($drink);
        $drink->name = $request->name;
        $drink->category = $request->category;
        $drink->ingredients = $request->ingredients;
        $drink->price = $request->price;

        $saved = $drink->save();
        if (!$saved) {
            return redirect()->back()->with(['error' => 'Something went wrong on server , please try again!']);
        }
        return redirect()->back()->with(['success' => 'The drink "' . $drink->name . '" edited successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Drink  $drink
     * @return \Illuminate\Http\Response
     */
    public function destroy($drink)
    {
        $this->authorize('auth');
        $drink = Drink::findOrFail($drink);
        $deleted = $drink->delete();
        if(!$deleted){
            return redirect()->back()->with(['error' => 'Something went wrong on server, please try again!']);
        }
        return redirect()->back()->with(['success' => 'The drink "' . $drink->name . '" deleted successfully']);
    }
}
