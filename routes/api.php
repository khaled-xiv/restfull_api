<?php


use App\Http\Controllers\Buyer\BuyerController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Http\Controllers\AccessTokenController;

Route::resource('users',UserController::class);
Route::name('verify')->get('users/verify/{token}',[UserController::class,'verify']);

Route::resource('buyers',BuyerController::class,
    ['only'=>['index','show']]);

Route::get('buyers/{buyer}/transactions',[BuyerController::class,'buyerTransactions']);
Route::get('buyers/{buyer}/products',[BuyerController::class,'buyerProducts']);
Route::get('buyers/{buyer}/sellers',[BuyerController::class,'buyerSellers']);
Route::get('buyers/{buyer}/categories',[BuyerController::class,'buyerCategories']);

Route::resource('products',ProductController::class,
    ['only'=>['index','show']]);

Route::post('sellers/{seller}/products',[ProductController::class,'store']);
Route::delete('sellers/{seller}/products/{product}',[ProductController::class,'destroy']);

Route::post('oauth/token',[AccessTokenController::class,'issueToken']);
