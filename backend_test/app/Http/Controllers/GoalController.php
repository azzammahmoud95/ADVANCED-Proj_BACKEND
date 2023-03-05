<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GoalController extends Controller
{
    //*********** GET GOAL */
    public function getAllGoal(){
        try{
            $goal = Goal::with('currency')->get();
            return response()->json([
                'message'=> $goal
            ]);

        }
        catch (\Exception $err) {
            return response()->json([
                'message' =>  $err->getMessage(),  
            ], 500); // 500 status code indicates internal server error
        }
    }
    //********* GET GOAL BY ID */
    public function getGoal(Request $request,$id){
        try{
            $goal = Goal::where('id', $id)->with('currency')->get();

            return response()->json([
                'message' => $goal
            ]);
        }
        catch (\Exception $err) {
            return response()->json([
                'message' =>  $err->getMessage(),  
            ], 500); // 500 status code indicates internal server error
        }
    }

    //*********** ADD GOAL *************************/
    public function addGoal(Request $request){
        try{
            $goal = new Goal;
            $currency_id = $request->input('currency_id');
            $currency = Currency::find($currency_id);
            $amount = $request->input('amount');
            $schedule = $request->input('schedule');
            $validator = Validator::make($request->all(),[
                'schedule' => 'required|in:weekly,monthly,yearly',
                'currency_id' => 'required|exists:currencies,id',
                'amount' => 'required|numeric',
            ]);
            if($validator->fails()){
                $respond['message'] = $validator->errors();
                return $respond;
            }

            $goal->amount = $amount;
            $goal->schedule = $schedule;
            $goal->currency()->associate($currency);
            $goal->save();

        return response()->json([
            'message' => $goal
     
        ]);
        }
        catch (\Exception $err) {
            return response()->json([
                'message' =>  $err->getMessage(),  
            ], 500); // 500 status code indicates internal server error
        }
    }
    // *********************** DELETE GOAL ************************
    public function deleteGoal(Request $request,$id){
        try{
            $goal = Goal::find($id);
            $goal->delete();

           return response()->json([
                'message' => 'Goal deleted successfully'
            ]);
        }
        catch (\Exception $err) {
            return response()->json([
                'message' =>  $err->getMessage(),  
            ], 500); // 500 status code indicates internal server error
        }
    }
    // ************ Edit Goal ****************************
    // public function editGoal(Request $request, $id){
    //     try{
    //         $goal = Goal::find($id);
    //         $inputs = request()->except('currencies','_method');
    //         $goal->update($inputs);
    //         if($request->has('currencies')){
    //             $goal->currency()->sync(json_decode($request->input('currencies')));
    //         }
    //         return response()->json([
    //             'goal' => $goal
    //         ]);
    //     }
    //     catch (\Exception $err) {
    //         return response()->json([
    //             'message' =>  $err->getMessage(),  
    //         ], 500); // 500 status code indicates internal server error
    //     }
    // }
    public function editGoal(Request $request, $id){
        try {
            $goal = Goal::find($id);
            $inputs = $request->except('_method');
            $goal->update($inputs);
    
            if ($request->has('currency_id')) {
                $currency_id = $request->input('currency_id');
                $currency = Currency::find($currency_id);
                $goal->currency()->associate($currency);
                $goal->save();
            }
    
            return response()->json([
                'goal' => $goal
            ]);
        } catch (\Exception $err) {
            return response()->json([
                'message' =>  $err->getMessage(),
            ], 500); // 500 status code indicates internal server error
        }
    }
    
    
    
    

}
