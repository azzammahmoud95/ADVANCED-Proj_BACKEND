<?php

namespace App\Http\Controllers;

use App\Models\Fixed_key;
use Illuminate\Http\Request;

class FixedKeyController extends Controller
{
    //********** GET ALL FIXED KEY */
    public function getAllFixedKey() 
    {
        $fixed_key = Fixed_key::all();
        return response()->json([
            'fixed_key' => $fixed_key,
        ]);
    }
    //*********** GET FIXED KEY BY ID */
    public function getFixedKey(Request $request, $id){
        try{
             $key =  Fixed_key::find($id);
  
             return response()->json(['message' => $key]);

        } catch(\Exception $err){
            return response()->json(['error' => 'Fixed_key NOT FOUND',] , 404); 

        }
      
    }
    // **************add fixed key ****************************
    public function  addFixedKey(Request $request){
        try{
            $key = new Fixed_key;
            $title = $request->input('title');
            $description = $request->input('description');
            $is_active = $request->input('is_active',true);
            $request->validate([
                'title' => 'required',
                'description' => 'required',
                'is_active' => 'boolean'
            ]);

            $key->title = $title;
            $key->description = $description;
            $key->is_active = $is_active;
            $key->save();
            return response()->json(['message' => $key]);
        }
        catch (\Exception $err) {
            return response()->json([
                'message' =>  $err->getMessage(),  
            ], 500); // 500 status code indicates internal server error
        }
    }
    //****************EDIT FIXED KEY */
    public function editFixedKey(Request $request, $id)
        {
            try {
                $key = Fixed_key::findOrFail($id);
                $inputs = $request->except('_method');
                $key->update($inputs);
                
                return response()->json([
                    'key' => $key,
                ]);
            }catch (\Exception $err) {
                return response()->json([
                    'message' => 'Error updating Fixed_key: ' . $err->getMessage(),  
                ], 500); 
            }
        }
        //*************** DELETE FIXED KEY */
        public function deleteFixedKey(Request $request, $id){
            try{      
            $key =  Fixed_key::find($id);
            $key->delete();
            return response()->json([
                'message' => 'Fixed_key deleted Successfully!',
         
            ]);}
            catch (\Exception $err) {
                return response()->json([
                    'message' => 'Error adding currency: ' . $err->getMessage(),  
                ], 500); // 500 status code indicates internal server error
            }
        }
}
