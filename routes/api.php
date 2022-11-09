<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MainController;
use App\Http\Controllers\Api\Auth\ClientController ;//as CController;
use App\Http\Controllers\Api\Auth\RestaurantController;
use App\Http\Controllers\Api\ItemController;
use Illuminate\Routing\RouteGroup;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('v1')->namespace('Api')->group(function () {
    //start main
    Route::get('cities',[MainController::class,'cities']);
    Route::get('regions',[MainController::class,'regions']);
    Route::get('category',[MainController::class,'category']);
    //هعمل روت للاعدادات تعديل بس علي شان المفروض
    //انها خاصه بااصحاب الموقع وثابته في كلو وبيتعدل عليها بس صح ولا غلط
        Route::post('update-setting',[MainController::class,'updateSetting']);
        Route::get('setting',[MainController::class,'setting']);
    ///start client
    Route::prefix('client')->group(function(){
        Route::post('register',[ClientController::class,'register']);
        Route::post('login',[ClientController::class,'login']);
        Route::Post('reset',[ClientController::class,'reset']);
        Route::Post('Password',[ClientController::class,'Password']);
        Route::group(['middleware'=>'auth:client'],function(){
            Route::get('show-data',[ClientController::class,'showData']);
            Route::post('add-comment',[MainController::class,'addComent']);
            Route::post('update-profile',[ClientController::class,'updateProfile']);
            Route::post('update-profile',[ClientController::class,'updateProfile']);
            Route::post('new-order',[MainController::class,'newOrder']);
        });
    });
    ///start restaurant
    Route::prefix('restaurant')->group(function(){
        //main controller
            Route::get('restaurants',[MainController::class,'restaurants']);
            Route::get('restaurant',[MainController::class,'restaurant']);
            Route::get('itmes',[MainController::class,'restaurantItems']);
            Route::get('comments',[MainController::class,'comments']);
        //RestaurantController
            Route::post('register',[RestaurantController::class,'register']);
            Route::post('login',[RestaurantController::class,'login']);
        Route::group(['middleware'=>'auth:restaurant'],function(){
        //auth RestaurantController
            Route::get('show-data',[RestaurantController::class,'showData']);//get or post
            Route::post('update-profile',[RestaurantController::class,'updateProfile']);
            Route::post('add-offer',[RestaurantController::class,'addOffer']);
        //ItemController
            Route::post('add-item',[ItemController::class,'addItem']);
            Route::post('update-item',[ItemController::class,'updateItem']);
            Route::post('destroy-item',[ItemController::class,'destroy']);
        //Restaurant Orders Apis
            Route::post('restaurant-orders',[RestaurantController::class,'restaurantOrder']);
        });
    });
});
