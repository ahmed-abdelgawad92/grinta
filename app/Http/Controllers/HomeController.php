<?php

namespace App\Http\Controllers;

use App\Table;
use App\Meal;
use App\Drink;
use App\Order;
use Illuminate\Http\Request;
use App\Expense;
use App\OrderItem;
use App\User;

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
        
        $orders = Order::whereDate('created_at', $date)->where('table_id','!=', 22)->where('closed', 1)->get();
        $totalIn = Order::whereDate('created_at', $date)->where('table_id','!=', 22)->where('closed', 1)->selectRaw('SUM(total - discount) as totalIn')->value('totalIn');
        
        $orderItems = OrderItem::getProductWithDetails($date);
        
        $expenses = Expense::whereDate('date', $date)->get();
        $totalOut = Expense::whereDate('date', $date)->sum('amount');

        return view('order.dailyReport',[
            'orderItems' => $orderItems,
            'orders' => $orders,
            'expenses' => $expenses,
            'date' => $date,
            'totalIn' => $totalIn,
            'totalOut' => $totalOut,
            'active' => 'dailyReport'
        ]);
    }

    /**
     * monthly Report
     */
    public function monthlyReport($date = null)
    {
        $this->authorize('auth');

    }


    /**
     * monthly Report
     */
    public function userReport(Request $request)
    {
        $this->authorize('auth');

        $users = User::all();
        $user = null;
        $orders = [];
        $total = 0;
        $date_from = $request->date_from;
        $date_to = $request->date_to;

        if($request->user && $date_from && $date_to){
            $user = User::find($request->user);
            $orders = Order::where('user_id', $user->id)->where('created_at', '>=', $date_from)->where('created_at', '<=', $date_to)->where('table_id', '!=', 22)->where('closed', 1)->get();
            $total = Order::where('user_id', $user->id)->where('created_at', '>=', $date_from)->where('created_at', '<=', $date_to)->where('table_id', '!=', 22)->where('closed', 1)->selectRaw('SUM(total - discount) as totalIn')->value('totalIn');
        }

        // dd([$orders, $total]);

        return view('order.userReport', [
            'orders' => $orders,
            'users' => $users,
            'currentUser' => $user,
            'total' => $total,
            'from' => $date_from,
            'to' => $date_to,
            'active' => 'userReport'
        ]);
    }
}
