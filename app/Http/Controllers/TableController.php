<?php

namespace App\Http\Controllers;

use App\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function __construct(){
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
        $tables = Table::all();
        return view('table.all', ['active' => 'table', 'tables' => $tables]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('auth');
        return view('table.add', ['active' => 'createTable']);
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
            'type' => 'required|in:normal,ps',
            'ps_price' => 'nullable|required_if:type,ps|numeric',
            'ps_multi_price' => 'nullable|required_if:type,ps|numeric'
        ]);

        $table = new Table;
        $table->name           = $request->name;
        $table->type           = $request->type;
        $table->ps_price       = $request->ps_price;
        $table->ps_multi_price = $request->ps_multi_price;
        
        $saved = $table->save();
        if(!$saved){
            return redirect()->back()->with(['error'=>'Something went wrong on server , please try again!']);
        }
        return redirect()->back()->with(['success'=>'The table "'.$table->name.'" created successfully']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function edit($table)
    {
        $this->authorize('auth');
        return view('table.edit', ['active' => 'table', 'table' => Table::findOrFail($table)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $table)
    {
        $this->authorize('auth');
        $request->validate([
            'name' => 'required',
            'type' => 'required|in:normal,ps',
            'ps_price' => 'nullable|required_if:type,ps|numeric',
            'ps_multi_price' => 'nullable|required_if:type,ps|numeric'
        ]);

        $table = Table::findOrFail($table);
        $table->name = $request->name;
        $table->type = $request->type;
        $table->ps_price       = $request->ps_price;
        $table->ps_multi_price = $request->ps_multi_price;

        $saved = $table->save();
        if (!$saved) {
            return redirect()->back()->with(['error' => 'Something went wrong on server , please try again!']);
        }
        return redirect()->back()->with(['success' => 'The table "' . $table->name . '" edited successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function destroy($table)
    {
        $this->authorize('auth');
        $table = Table::findOrFail($table);
        $deleted = $table->delete();
        if (!$deleted) {
            return redirect()->back()->with(['error' => 'Something went wrong on server , please try again!']);
        }
        return redirect()->back()->with(['success' => 'The table "' . $table->name . '" is deleted successfully']);
    }
}
