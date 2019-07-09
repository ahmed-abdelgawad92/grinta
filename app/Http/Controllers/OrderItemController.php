<?php

namespace App\Http\Controllers;

use App\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderItemController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $orders = $request->order;
        if(!$orders){ 
            return response()->json(['status' => 'NOK', 'msg' => 'The order is empty please add items to the order!']); 
        }
        $orderId = $request->orderId;
        try{
            DB::beginTransaction();
            foreach($orders as $order){
                $array = explode('_', $order['id']);
                $item = new OrderItem;
                $item->order_id = $orderId;
                $item->item_type = $array[0];
                if($item->item_type == 'drink'){
                    $item->drink_id = $array[1];
                }else{
                    $item->meal_id = $array[1];
                }
                $item->amount = $order['amount'];
                $item->price = $order['price'];
                $item->save();
            }
            DB::commit();
            return response()->json(['status' => 'OK']);
        }catch(Exception $e){
            DB::rollback();
            return response()->json(['status' => 'NOK', 'msg' => 'Something went wrong on server please try again']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OrderItem  $orderItem
     * @return \Illuminate\Http\Response
     */
    public function show($orderItem)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OrderItem  $orderItem
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderItem $orderItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OrderItem  $orderItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderItem $orderItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OrderItem  $orderItem
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $orderItem = OrderItem::findOrFail($id);
        $order = $orderItem->order;
        if($order->closed){
            return redirect()->back()->with(['error' => "You can't remove an item from a closed order"]);
        }else{
            $orderItem->delete();
            $name = $orderItem->drink->name ?? $orderItem->meal->name;

            $reservations = $order->reservations;
            $orderItems = $order->orderItem;

            if(count($reservations) == 0 && count($orderItems) == 0){
                $table = $order->table;
                $table->state = "free";
                $table->save();
                $order->delete();
                return redirect()->route('home')->with(['success' => 'The item "' . $name . '" is successfully removed from the order']);
            }
            return redirect()->back()->with(['success' => 'The item "' . $name . '" is successfully removed from the order']);
        }
    }
}
