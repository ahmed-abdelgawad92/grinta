<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Order;
class Table extends Model
{
    //get the last opened order
    public function currentOrder()
    {
        return Order::where('table_id',$this->id)->where('closed', 0)->orderBy('created_at', 'desc')->first();
    }
    //reservations 
    public function reservations(){
        return $this->hasManyThrough('App\Reservation', 'App\Order');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    //has unclosed order
    public function hasUnClosedOrders()
    {
        return $this->orders()->where('closed', 0)->count();
    }
}
