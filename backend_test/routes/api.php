<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\FixedKeyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Category Routes
Route::get('/categories',[CategoryController::class,'getAllCategory']);
Route::get('/categories/{id}',[CategoryController::class,'getCategory']);
Route::post('/categories',[CategoryController::class,'addCategory']);
Route::patch('/categories/{id}',[CategoryController::class,'editCategory']);
Route::delete('/categories/{id}',[CategoryController::class,'deleteCategory']);

//Currency Routes
Route::get('/currency',[CurrencyController::class,'getAllCurrency']);
Route::get('/currency/{id}',[CurrencyController::class,'getCurrency']);
Route::post('/currency',[CurrencyController::class,'addCurrency']);
Route::patch('/currency/{id}',[CurrencyController::class,'editCurrency']);
Route::delete('/currency/{id}',[CurrencyController::class,'deleteCurrency']);

//KeyController
Route::Get('/key',[FixedKeyController::class,'getAllFixedKey']);
Route::Get('/key/{id}',[FixedKeyController::class,'getFixedKey']);
Route::post('/key',[FixedKeyController::class,'addFixedKey']);
Route::delete('/key/{id}',[FixedKeyController::class,'deleteFixedKey']);
Route::Patch('/key/{id}',[FixedKeyController::class,'editFixedKey']);