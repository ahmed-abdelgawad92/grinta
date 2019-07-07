<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrderItem extends Model
{
    protected $table = "order_item";

    public static function checkout($order_id)
    {
        return DB::select( '
            SELECT name, meals.price AS price, SUM(amount) AS amount, SUM(meals.price * amount) AS total FROM order_item 
            LEFT JOIN meals on meals.id = order_item.meal_id
            WHERE 
                order_id = :id
            AND 
                order_item.meal_id IS NOT NULL
            AND 
                order_item.canceled = 0
            GROUP BY 
                order_item.drink_id
            UNION 
            SELECT name, drinks.price AS price, SUM(amount) AS amount, SUM(drinks.price * amount) AS total FROM order_item
            LEFT JOIN drinks on drinks.id = order_item.drink_id
            WHERE 
                order_id = :oid
            AND 
                order_item.drink_id IS NOT NULL
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

    public function drink()
    {
        return $this->belongsTo('App\Drink');
    }

    public function meal()
    {
        return $this->belongsTo('App\Meal');
    }
}
