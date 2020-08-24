<?php

namespace App\Http\Controllers;

use App\Table;
use App\Meal;
use App\Drink;
use App\Order;
use Illuminate\Http\Request;
use App\Expense;
use App\OrderItem;
use App\Reservation;
use App\User;
use Illuminate\Support\Facades\DB;

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
        
        // $reservations = Reservation::whereDate('created_at', $date)->where('time_to','!=', null )->orderBy('updated_at', 'ASC')->get();
        $reservations = Reservation::getWhereOrderIsClosed($date);
        $total_ps     = Reservation::getTotalWhereOrderIsClosed($date);
        
        $orders   = Order::whereDate('created_at', $date)->where('closed', 1)->orderBy('paid_at', 'ASC')->orderBy('updated_at', 'ASC')->get();
        $totalIn  = Order::whereDate('created_at', $date)->where('closed', 1)->selectRaw('SUM(total) as totalIn')->value('totalIn');
        $totalIn -= Order::whereDate('created_at', $date)->where('closed', 1)->selectRaw('SUM(discount) as discount')->value('discount');

        $orderItems  = OrderItem::getProductWithDetails($date);
        $items_total = 0;
        
        foreach($orderItems as $item) {
            $items_total += $item->total;
        }
        
        $expenses = Expense::whereDate('date', $date)->get();
        $totalOut = Expense::whereDate('date', $date)->sum('amount');

        return view('order.dailyReport',[
            'orderItems' => $orderItems,
            'items_total' => $items_total,
            'orders' => $orders,
            'reservations' => $reservations,
            'total_ps' => $total_ps,
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
    public function rangeReport(Request $request)
    {
        $this->authorize('auth');

        $date_from = $request->date_from ?? '';
        $date_to = $request->date_to ?? '';
        $orders = [];
        $orderItems = [];
        $totalIn = 0;
        $totalOut = 0;
        $expenses = [];

        if($date_from != '' && $date_to != ''){
            $orders = Order::whereDate('created_at', '>=', $date_from)->whereDate('created_at', '<=', $date_to)->where('table_id', '!=', 22)->where('closed', 1)->orderBy('paid_at', 'ASC')->orderBy('updated_at', 'ASC')->get();
            $totalIn = Order::whereDate('created_at', '>=', $date_from)->whereDate('created_at', '<=', $date_to)->where('table_id', '!=', 22)->where('closed', 1)->selectRaw('SUM(total) as totalIn')->value('totalIn');
            $totalIn -= Order::whereDate('created_at', '>=', $date_from)->whereDate('created_at', '<=', $date_to)->where('table_id', '!=', 22)->where('closed', 1)->selectRaw('SUM(discount) as discount')->value('discount');
    
            $orderItems = OrderItem::getProductWithDetailsRange($date_from, $date_to);
    
            $expenses = Expense::whereDate('date', '>=', $date_from)->whereDate('date', '<=', $date_to)->get();
            $totalOut = Expense::whereDate('date', '>=', $date_from)->whereDate('date', '<=', $date_to)->sum('amount');
        }

        return view('order.rangeReport', [
            'orderItems' => $orderItems,
            'orders' => $orders,
            'expenses' => $expenses,
            'date_from' => $date_from,
            'date_to' => $date_to,
            'totalIn' => $totalIn,
            'totalOut' => $totalOut,
            'active' => 'rangeReport'
        ]);
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
            $orders = Order::where('user_id', $user->id)->where('created_at', '>=', $date_from)->where('created_at', '<=', $date_to)->where('table_id', '!=', 22)->where('closed', 1)->orderBy('paid_at', 'ASC')->get();
            $total = Order::where('user_id', $user->id)->where('created_at', '>=', $date_from)->where('created_at', '<=', $date_to)->where('table_id', '!=', 22)->where('closed', 1)->selectRaw('SUM(total) as totalIn')->value('totalIn');
            $total -= Order::where('user_id', $user->id)->where('created_at', '>=', $date_from)->where('created_at', '<=', $date_to)->where('table_id', '!=', 22)->where('closed', 1)->selectRaw('SUM(discount) as discount')->value('discount');
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
