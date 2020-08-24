<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Reservation extends Model
{
    public static function checkout($id)
    {
        session(['order'.$id => date("Y-m-d H:i:s")]);
        return DB::select('
            SELECT reservations.id as id, multi, time_from, time_to, reservations.price as price
            FROM reservations 
            JOIN orders ON orders.id = reservations.order_id
            JOIN tables ON tables.id = orders.table_id
            WHERE 
                reservations.order_id = :id 
            
        ', ['id' => $id]);
    }

    public static function getWhereOrderIsClosed($date)
    {
        return DB::select('
            SELECT reservations.id as id, multi, time_from, time_to, reservations.price as price, reservations.created_at, reservations.updated_at, tables.name as table_name
            FROM reservations 
            INNER JOIN orders ON orders.id = reservations.order_id AND orders.closed = 1
            INNER JOIN tables ON orders.table_id = tables.id
            WHERE 
                DATE(orders.created_at) = :date
            AND 
                reservations.time_to IS NOT NULL
        ', ['date' => $date]);
    }

    public static function getTotalWhereOrderIsClosed($date)
    {
        $result = DB::select('
            SELECT 
                SUM(
                    ROUND(
                        ((UNIX_TIMESTAMP(reservations.time_to) - UNIX_TIMESTAMP(reservations.time_from)) / 3600) * reservations.price
                    )
                ) as total_ps
            FROM reservations 
            INNER JOIN orders ON orders.id = reservations.order_id AND orders.closed = 1
            WHERE 
                DATE(orders.created_at) = :date
            AND 
                reservations.time_to IS NOT NULL
        ', ['date' => $date]);

        if(count($result) > 0) {
            return $result[0]->total_ps;
        }

        return 0;
    }

    public function order()
    {
        return $this->belongsTo('App\Order');
    }
}
