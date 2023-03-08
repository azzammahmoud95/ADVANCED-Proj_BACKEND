<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\FixedKeyController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\FixedTransController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

//Goal Routes
Route::get('/goal',[GoalController::class,'getAllGoal']);
Route::get('/goal/{id}',[GoalController::class,'getGoal']);
Route::post('/goal',[GoalController::class,'addGoal']);
Route::patch('/goal/{id}',[GoalController::class,'editGoal']);
Route::delete('/goal/{id}',[GoalController::class,'deleteGoal']);

// Fixed Transactions
Route::post('/fixedtransaction',[FixedTransController::class,'addFixedTransaction']);
// Route::patch('/fixedtransaction/{id}',[FixedTransController::class,'editFixedTransaction']);
// Route::delete('/fixedtransaction/{id}',[FixedTransController::class,'deleteFixedTransaction']);
Route::get('/fixedtransaction',[FixedTransController::class,'getAllFixedTransactions']);
Route::get('/fixedtransaction/{id}',[FixedTransController::class,'getFixedTransactionById']);
// Route::get('/fixedtransaction', [FixedTransController::class,'getBy']);



Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/admin-profile', [AuthController::class, 'adminProfile']);    
});
