<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\OrderItem;
use App\Table;
use App\Reservation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
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
    public function show($id)
    {
        $this->authorize('auth');
        $currentOrder = Order::findOrFail($id);
        $orders = $currentOrder->orderItem;
        $reservations = $currentOrder->reservations;
        $table = $currentOrder->table;
        return view('order.show', [
            'currentOrder' => $currentOrder,
            'orders' => $orders,
            'reservations' => $reservations,
            'table' => $table,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        try{
            DB::beginTransaction();
            $table = Table::findOrFail($id);
            if($table == 'busy' || $table->hasUnclosedOrders() > 0){
                return redirect()->back()->with('error','This table has unclosed orders !');
            }
            $table->state = 'busy';
            $table->save();
            
            $order = new Order;
            $order->table_id = $id;
            $order->user_id = Auth::user()->id;
            $order->save();
    
            if($table->type == 'ps'){
                $now = date("Y-m-d H:i:s");
                $reservation = new Reservation;
                $reservation->time_from = $now;
                $reservation->multi = $request->multi;
                $reservation->price = $reservation->multi ? $table->ps_multi_price : $table->ps_price;
                if(!empty($request->hours)){
                    $reservation->time_to = date('Y-m-d H:i:s', strtotime($now . ' +'. $request->hours . ' hours'));
                }
                $reservation->order_id = $order->id;
                $reservation->save();
            }
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
            return redirect()->back()->with(['error' => 'Something went wrong on the server please try again!']);
        }
        return redirect()->route('home')->with(['success'=>'Order created successfully']);
    }

    public function checkout($id)
    {
        $order = Order::find($id);
        if($order->closed){
            return redirect()->route('home')->with('error','This order is already closed!');
        }
        $table = $order->table;
        $orders = OrderItem::checkout($id);
        $reservations = Reservation::checkout($id);
        $total = OrderItem::total($id)[0]->total;
        if(!$reservations && !$orders){
            return redirect()->route('home')->with(['error' => 'There are no orders or reservations yet to checkout!']);
        }
        $data = [
            'orders' => $orders,
            'reservations' => $reservations,
            'total' => $total,
            'table' => $table,
            'id' => $id
        ];
        // dd($data);
        return view('order.checkout', $data);

    }

    public function pay(Request $request, $id)
    {
        $session = $request->session()->all();
        try{
            DB::beginTransaction();
            $order = Order::findOrFail($id);
            $request->validate(['discount' => 'nullable|numeric']);
            $time_to      = $session['order' . $id];
            $request->session()->forget('order' . $id);
            $total        = OrderItem::total($id)[0]->total;
            $reservations = Reservation::checkout($id);
            
            foreach($reservations as $reservation){
                $from = strtotime($reservation->time_from);
                $to   = $reservation->time_to ? strtotime($reservation->time_to) : strtotime($time_to);
                $price = round((($to - $from) / 3600) * $reservation->price);
                
                $total += $price;
                if(!$reservation->time_to){
                    $res = Reservation::findOrFail($reservation->id);
                    $res->time_to = $time_to;
                    $res->save();
                }
            }
    
            if($request->discount){
                $order->discount = $request->discount;
            }
            $order->closed = 1;
            $order->total = $total;
            $order->user_id = Auth::user()->id;
            $order->save();
    
            $table = $order->table;
            $table->state = 'free';
            $table->save();
            DB::commit();
        }catch (Exception $e){
            DB::rollback();
            return redirect()->back()->with('error', 'Something went wrong on the server please try again!');
        }
        return redirect()->route('home')->with(['success' => 'Order paid successfully!']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function changeMulti(Request $request, $id)
    {
        $time_to     = date("Y-m-d H:i:s");
        $reservation = Reservation::findOrFail($id);
        //close old reservation
        $multi = $reservation->multi;
        $reservation->time_to = $time_to;
        $reservation->save();
        //create new reservation 
        $newReservation = new Reservation;
        $newReservation->order_id = $reservation->order_id;
        $newReservation->time_from = $time_to;
        $newReservation->price = $reservation->price;
        $newReservation->multi = ! $multi;
        $newReservation->save();

        $multi_text = $multi ? 'Single' : 'Multi';
        return redirect()->back()->with(['success' => 'PS Reservation is successfully changed to ' . $multi_text]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->back()->with(['success'=>'The order #'. $order->id .' is successfully deleted']);
    }
}
