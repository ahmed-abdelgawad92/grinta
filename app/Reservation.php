<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Reservation extends Model
{
    public static function checkout($id)
    {
        session(['order'.$id => now()]);
        return DB::select('
            SELECT reservations.id as id, multi, time_from, time_to, reservations.price as price
            FROM reservations 
            JOIN orders ON orders.id = reservations.order_id
            JOIN tables ON tables.id = orders.table_id
            WHERE 
                orders.id = :id 
            
        ', ['id' => $id]);
    }
}
