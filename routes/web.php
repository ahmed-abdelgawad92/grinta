<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('home');

//table routes 
Route::group(['prefix' => 'tables'], function () {
    //get all table
    Route::get('/all', [
        'uses' => 'TableController@index',
        'as'   => 'allTable'
    ]);
    //add new table
    Route::get('/create', [
        'uses' => 'TableController@create',
        'as'   => 'createTable'
    ]);
    Route::post('/create', [
        'uses' => 'TableController@store',
        'as'   => 'createTable'
    ]);
    //edit a table
    Route::get('/edit/{id}', [
        'uses' => 'TableController@edit',
        'as'   => 'editTable'
    ])->where('id', '[0-9]+');
    Route::put('/edit/{id}', [
        'uses' => 'TableController@update',
        'as'   => 'editTable'
    ])->where('id', '[0-9]+');
    //delete table
    Route::delete('/delete/{id}', [
        'uses' => 'TableController@destroy',
        'as'   => 'deleteTable'
    ])->where('id', '[0-9]+');
});

//meals routes 
Route::group(['prefix' => 'meals'], function () {
    //get all meals
    Route::get('/all', [
        'uses' => 'MealController@index',
        'as'   => 'allMeal'
    ]);
    //add a new meal
    Route::get('/create', [
        'uses' => 'MealController@create',
        'as'   => 'createMeal'
    ]);
    Route::post('/create', [
        'uses' => 'MealController@store',
        'as'   => 'createMeal'
    ]);
    //edit a meal
    Route::get('/edit/{id}', [
        'uses' => 'MealController@edit',
        'as'   => 'editMeal'
    ])->where('id','[0-9]+');
    Route::put('/edit/{id}', [
        'uses' => 'MealController@update',
        'as'   => 'editMeal'
    ])->where('id','[0-9]+');
    //delete Meal
    Route::delete('/delete/{id}', [
        'uses' => 'MealController@destroy',
        'as'   => 'deleteMeal'
    ])->where('id', '[0-9]+');
});

//drinks routes 
Route::group(['prefix' => 'drinks'], function () {
    //get all drinks
    Route::get('/all', [
        'uses' => 'DrinkController@index',
        'as'   => 'allDrink'
    ]);
    //add a new drink
    Route::get('/create', [
        'uses' => 'DrinkController@create',
        'as'   => 'createDrink'
    ]);
    Route::post('/create', [
        'uses' => 'DrinkController@store',
        'as'   => 'createDrink'
    ]);
    //edit a drink
    Route::get('/edit/{id}', [
        'uses' => 'DrinkController@edit',
        'as'   => 'editDrink'
    ])->where('id','[0-9]+');
    Route::put('/edit/{id}', [
        'uses' => 'DrinkController@update',
        'as'   => 'editDrink'
    ])->where('id','[0-9]+');
    //delete drink
    Route::delete('/delete/{id}', [
        'uses' => 'DrinkController@destroy',
        'as'   => 'deleteDrink'
    ])->where('id','[0-9]+');
});

//users routes 
Route::group(['prefix' => 'users'], function () {
    //get all users
    Route::get('/all', [
        'uses' => 'UserController@index',
        'as'   => 'allUser'
    ]);
    //add a new User
    Route::get('/create', [
        'uses' => 'UserController@create',
        'as'   => 'createUser'
    ]);
    Route::post('/create', [
        'uses' => 'UserController@store',
        'as'   => 'createUser'
    ]);
    //edit a User
    Route::get('/edit/{id}', [
        'uses' => 'UserController@edit',
        'as'   => 'editUser'
    ])->where('id','[0-9]+');
    Route::put('/edit/{id}', [
        'uses' => 'UserController@update',
        'as'   => 'editUser'
    ])->where('id','[0-9]+');
    //change password of a User
    Route::get('/change_password', function(){
        return view('user.password');
    });
    Route::put('/change_password', [
        'uses' => 'UserController@changePassword',
        'as'   => 'changePassword'
    ]);
    //delete User
    Route::delete('/delete/{id}', [
        'uses' => 'UserController@destroy',
        'as'   => 'deleteUser'
    ])->where('id','[0-9]+');
});

//orders routes 
Route::group(['prefix' => 'orders'], function () {
    //add a new order
    Route::post('/create/{id}', [
        'uses' => 'OrderController@store',
        'as'   => 'createOrder'
    ])->where('id','[0-9]+');
    //reservation change multi
    Route::post('/reservation/change/{id}', [
        'uses' => 'OrderController@changeMulti',
        'as'   => 'changeMulti'
    ])->where('id','[0-9]+');
    //checkout
    Route::get('/checkout/{id}', [
        'uses' => 'OrderController@checkout',
        'as'   => 'checkout'
    ])->where('id','[0-9]+');
    //pay
    Route::post('/pay/{id}', [
        'uses' => 'OrderController@pay',
        'as'   => 'pay'
    ])->where('id','[0-9]+');

    //order items routes 
    Route::group(['prefix' => 'item'], function () {
        //add a new order item
        Route::post('/create', [
            'uses' => 'OrderItemController@store',
            'as'   => 'createOrderItem'
        ]);
        //add a new order item
        Route::get('/{id}', [
            'uses' => 'OrderController@show',
            'as'   => 'showOrderItem'
        ]);
    });
});
//order items routes 
Route::group(['prefix' => 'report'], function () {
    //add a new order item
    Route::get('/daily', [
        'uses' => 'HomeController@dailyReport',
        'as'   => 'dailyReport'
    ]);
});

