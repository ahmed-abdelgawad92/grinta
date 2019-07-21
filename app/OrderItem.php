<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrderItem extends Model
{
    protected $table = "order_item";

    public static function checkout($order_id)
    {
        return DB::select(
            '
            SELECT order_item.id AS id, name, order_item.price AS price, SUM(amount) AS amount, SUM(order_item.price * amount) AS total FROM order_item 
            LEFT JOIN meals on meals.id = order_item.meal_id
            WHERE 
                order_id = :id
            AND 
                order_item.meal_id IS NOT NULL
            AND 
                order_item.drink_id IS NULL
            AND 
                order_item.canceled = 0
            GROUP BY 
                order_item.meal_id
            UNION 
            SELECT order_item.id AS id, name, order_item.price AS price, SUM(amount) AS amount, SUM(order_item.price * amount) AS total FROM order_item
            LEFT JOIN drinks on drinks.id = order_item.drink_id
            WHERE 
                order_id = :oid
            AND 
                order_item.drink_id IS NOT NULL
            AND 
                order_item.meal_id IS NULL
            AND 
                order_item.canceled = 0
            GROUP BY 
                order_item.drink_id
            
        '
        , ['id' => $order_id, 'oid' => $order_id]);
    }

    public static function total($id)
    {
        return DB::select('SELECT SUM(price * amount) AS total FROM order_item WHERE order_id = :id AND canceled = 0', ['id' => $id]);
    }

    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function drink()
    {
        return $this->belongsTo('App\Drink');
    }

    public function meal()
    {
        return $this->belongsTo('App\Meal');
    }

    public static function getProductWithDetails($date)
    {
        return DB::select(
            '
            SELECT order_item.id AS id, name, order_item.price AS price, SUM(amount) AS amount, SUM(order_item.price * amount) AS total FROM order_item 
            LEFT JOIN meals on meals.id = order_item.meal_id
            WHERE 
                date(order_item.created_at) = ?
            AND 
                order_item.meal_id IS NOT NULL
            AND 
                order_item.drink_id IS NULL
            AND 
                order_item.canceled = 0
            GROUP BY 
                order_item.meal_id
            UNION 
            SELECT order_item.id AS id, name, order_item.price AS price, SUM(amount) AS amount, SUM(order_item.price * amount) AS total FROM order_item
            LEFT JOIN drinks on drinks.id = order_item.drink_id
            WHERE 
                date(order_item.created_at) = ?
            AND 
                order_item.drink_id IS NOT NULL
            AND 
                order_item.meal_id IS NULL
            AND 
                order_item.canceled = 0
            GROUP BY 
                order_item.drink_id
            
        ',
            [$date, $date]
        );
    }


    public static function getProductWithDetailsRange($from, $to)
    {
        return DB::select(
            '
            SELECT order_item.id AS id, name, order_item.price AS price, SUM(amount) AS amount, SUM(order_item.price * amount) AS total FROM order_item 
            LEFT JOIN meals on meals.id = order_item.meal_id
            WHERE 
                date(order_item.created_at) >= date(:from)
            AND 
                date(order_item.created_at) <= date(:to)
            AND 
                order_item.meal_id IS NOT NULL
            AND 
                order_item.drink_id IS NULL
            AND 
                order_item.canceled = 0
            GROUP BY 
                order_item.meal_id
            UNION 
            SELECT order_item.id AS id, name, order_item.price AS price, SUM(amount) AS amount, SUM(order_item.price * amount) AS total FROM order_item
            LEFT JOIN drinks on drinks.id = order_item.drink_id
            WHERE 
                date(order_item.created_at) >= date(:from_f)
            AND 
                date(order_item.created_at) <= date(:to_to)
            AND 
                order_item.drink_id IS NOT NULL
            AND 
                order_item.meal_id IS NULL
            AND 
                order_item.canceled = 0
            GROUP BY 
                order_item.drink_id
            
        ',
            [ 'from' => $from, 'to' => $to, 'from_f' => $from, 'to_to' => $to]
        );
    }
}
