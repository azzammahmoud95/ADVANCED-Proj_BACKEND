<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Fixed_key;
use App\Models\Fixed_transaction;
use App\Models\Currency;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
class FixedTransController extends Controller
{
    //********* GET ALL FIXED TRANSACTIONS */
    public function getAllFixedTransactions(){
        try{
            $fixed_transaction = Fixed_transaction::with(['currency','category','fixed_key'])->get();
            return response()->json([
                'message' => $fixed_transaction
            ]);
        }
        catch (\Exception $err) {
            return response()->json([
                'message' =>  $err->getMessage(),
            ], 500); // 500 status code indicates internal server error
        }
    }
    //*********** GET FIXED TRANS BY ID */
    public function getFixedTransactionById(Request $request, $id){
        try{
            $fixed_transaction = Fixed_transaction::with(['currency','category','fixed_key'])->find($id);
                        return response()->json([
              'message' =>  $fixed_transaction
            ]);
        }
        catch (\Exception $err) {
            return response()->json([
                'message' =>  $err->getMessage(),
            ], 500); // 500 status code indicates internal server error
        }

    }
    //****** ADD FIXED TRANSACTION */
    public function addFixedTransaction(Request $request)
{
    try {
        $fixed_transaction = new Fixed_transaction;
        $start_date = $request->input('start_date');
        $amount = $request->input('amount');
        $schedule = $request->input('schedule');
        $is_paid = $request->input('is_paid', false);

        $currency_id = $request->input('currency_id');
        $currency = Currency::find($currency_id);

        $category_id = $request->input('category_id');
        $category = Category::find($category_id);

        $fixed_key_id = $request->input('fixed_key_id');
        $fixed_key = Fixed_key::find($fixed_key_id);

        $validator = Validator::make($request->all(), [
            'schedule' => 'required|in:weekly,monthly,yearly',
            // 'fixed_key_id' => 'required|exists:fixed_key,id',
            'amount' => 'required|numeric',
            'is_paid' =>  'boolean',
            'currency_id'=> 'required|exists:currencies,id',
            'category_id' => 'required|exists:categories,id',
        ]);
        if($validator->fails()){
            $respond['message'] = $validator->errors();
            return $respond;
        }
        

        $fixed_transaction->amount = $amount;
        $fixed_transaction->start_date = $start_date;
        $fixed_transaction->schedule = $schedule;
        $fixed_transaction->is_paid = $is_paid;
        $fixed_transaction->currency()->associate($currency);
        $fixed_transaction->category()->associate($category);
        $fixed_transaction->fixedkey()->associate($fixed_key);
        $fixed_transaction->next_payment_date = Carbon::parse($start_date);

        $fixed_transaction->save();

        if ($schedule === 'weekly') {
            $interval = '1 week';
        } elseif ($schedule === 'monthly') {
            $interval = '1 month';
        } elseif ($schedule === 'yearly') {
            $interval = '1 year';
        }

        $next_date = Carbon::parse($start_date)->add($interval);
        $today = Carbon::today();

        while ($next_date->lte($today)) {
            $next_transaction = new Fixed_transaction;
            $next_transaction->amount = $amount;
            $next_transaction->start_date = $next_date->toDateString();
            $next_transaction->schedule = $schedule;
            $next_transaction->currency()->associate($currency);
            $next_transaction->category()->associate($category);
            $next_transaction->fixedkey()->associate($fixed_key);
            $next_transaction->is_paid = false;
            $next_transaction->save();
            $next_date->add($interval);
        }

        return response()->json([
            'message' => $fixed_transaction,
        ]); // successed response
    } catch (\Exception $err) {
        return response()->json([
            'message' => 'Error adding fixed transaction: ' . $err->getMessage(),
        ], 500); // 500 status code indicates internal server error
    }
}
   
}
