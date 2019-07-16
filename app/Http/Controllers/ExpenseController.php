<?php

namespace App\Http\Controllers;

use App\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
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
    public function index(Request $request)
    {
        $this->authorize('auth');
        $date = $request->date ?? date('Y-m-d');
        $expenses = Expense::where('date', $date)->get();
        $total = Expense::where('date', $date)->sum('amount');
        return view('expense.all', [
            'active' => 'expense',
            'expenses' => $expenses,
            'date' => $date,
            'total' => $total
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('auth');
        return view('expense.add', ['active' => 'createExpense']);
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
            'amount' => 'required|numeric',
            'date' => 'nullable|date',
        ]);
        
        $date = $request->date;
        if(!$date){
            $date = date('Y-m-d');
        }

        $expense = new Expense;
        $expense->name = $request->name;
        $expense->amount = $request->amount;
        $expense->date = $date;
        $expense->user_id = Auth::user()->id;
        
        $saved = $expense->save();
        if(!$saved){
            return redirect()->back()->with('error', 'Something went wrong on the server, please try again');
        }
        return redirect()->back()->with('success', 'Expense is successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expense = Expense::findOrFail($id);
        $expense->delete();
        return redirect()->back()->with(['success' => 'The expense "' . $expense->name . ' ('. $expense->amount .' LE)" is successfully deleted']);
    }
}
