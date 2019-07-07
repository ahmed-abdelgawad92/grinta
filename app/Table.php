<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Order;
class Table extends Model
{
    //get the last opened order
    public function currentOrder()
    {
        return Order::where('table_id',$this->id)->where('closed', 0)->first();
    }
    //reservations 
    public function reservations(){
        return $this->hasManyThrough('App\Reservation', 'App\Order');
    }
}
