<?php

namespace App\Http\Controllers;

use App\Table;
use App\Meal;
use App\Drink;
use App\Order;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $tables = Table::all();
        $meals  = Meal::orderBy('category')->get();
        $drinks = Drink::orderBy('category')->get();

        return view('home', [
            'active' => 'dashboard',
            'tables' => $tables,
            'meals'  => $meals,
            'drinks' => $drinks,
        ]);
    }

    /**
     * Daily Report
     */
    public function dailyReport(Request $request)
    {
        // dd($request);
        $this->authorize('auth');
        $date = $request->date ?? date('Y-m-d');
        $orders = Order::whereDate('created_at', $date)->where('closed', 1)->get();
        $total = Order::whereDate('created_at', $date)->where('closed', 1)->sum('total');
        return view('order.dailyReport',[
            'orders' => $orders,
            'date' => $date,
            'total' => $total
        ]);
    }

    /**
     * monthly Report
     */
    public function monthlyReport($date = null)
    {
        $this->authorize('auth');

    }
}
