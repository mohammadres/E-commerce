<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\cartController;
use App\Http\Controllers\commentsController;
use App\Http\Controllers\favoritesController;
use App\Http\Controllers\likesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\profileController;
use App\Models\Category;
use App\Models\Product;

Route::get('/test',function(){dd('online');});







Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/ispler', [ProductsController::class, 'popular']);
Route::get('/product', [ProductsController::class, 'index']);
Route::post('/category', [CategoryController::class, 'category']);
Route::post('/search_by_name', [ProductsController::class, 'search_by_name']);
Route::post('/search_by_date', [ProductsController::class, 'search_by_date']);
Route::get('posts/{id}', [ProductsController::class, 'views']);
Route::post('/sort', [ProductsController::class, 'sort']);
Route::post('/user', [profileController::class, 'user']);
Route::get('price/{id}', [ProductsController::class, 'price']);

//////////////// Middleware Route ////////////////
Route::group(['middleware' => ['auth:sanctum']], function () {
   Route::post('user_image/{id}', [profileController::class, 'user_image']);
   Route::get('/logout', [AuthController::class, 'logout']);
   Route::post('comment/{id}', [commentsController::class, 'comment']);
   Route::post('/product/{id}', [ProductsController::class, 'update']);
   Route::post('/add', [ProductsController::class, 'addproduct']);
   Route::post('/delete', [ProductsController::class, 'delete']);
   Route::get('/getfavorite', [favoritesController::class, 'getfavorite']);
   Route::get('/like/{id}' , [likesController::class , 'like'] );
   Route::post('/show', [ProductsController::class, 'show']);
   Route::get('/product', [ProductsController::class, 'index']);
   Route::get('/favorite/{id}' , [favoritesController::class , 'favorite'] );
   Route::post('/AddToCart/{id}',[cartController::class,'AddToCart' ]);
   Route::get('/ShowUserCart',[cartController::class, 'ShowCart']);
   Route::post('/DeleteItemFromCart',[cartController::class, 'DeleteItem']);
});





