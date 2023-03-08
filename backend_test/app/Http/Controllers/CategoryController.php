<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    //***********ADD CATEGORY */
    public function addCategory(Request $request){
        try{
        $category = new Category;
        $name = $request->input('name');
        $type_code = $request->input('type_code');
        $request->validate([
            // 'type_code' => 'required|in:incomes,expenses',
            'name' => 'required',
        ]);

        $category->name = $name;
        $category->type_code = $type_code;
        
        $category->save();
        return response()->json([
            'message' => $request->all()
        ]);}
        catch (\Exception $err) {
            return response()->json([
                'message' =>  $err->getMessage(),  
            ], 500); // 500 status code indicates internal server error
        }
    }
    //*****************Get Category *****************/
    public function getCategory(Request $request, $id){
        try{
        $category = Category::findOrFail($id);

        return response()->json([
            'message' => $category
        ]);}
        catch (\Exception $err) {
            return response()->json([
                'message' =>  $err->getMessage(),  
            ], 500); // 500 status code indicates internal server error
        }
        
    }

    //*****************GET ALL CATEGORIES************ */
    public function getAllCategory(Request $request){
        try{
        $categories = Category::all();

        return response()->json([
            'message' => $categories
        ]);}
        catch (\Exception $err) {
            return response()->json([
                'message' =>  $err->getMessage(),  
            ], 500); // 500 status code indicates internal server error
        }
        
    }
    //************EDIT CATEGORY */
    public function editCategory(Request $request, $id){
        try{
        $category = category::find($id);
        $inputs = $request->except('_method');
        $category->update($inputs);
        $inputs = $request;
        return response()->json([
            'message' => 'category updated successfully',
            'category' => $category
        ]);}

        catch (\Exception $err) {
            return response()->json([
                'message' =>  $err->getMessage(),  
            ], 500); // 500 status code indicates internal server error
        }
    }
    //************ DELETE CATEGORY */
    public function deleteCategory(Request $request, $id){
        try{
        $category = category::find($id);
        $category->delete();

        return response()->json([
            'message' => 'category deleted successfully',
        ]);}
        catch (\Exception $err) {
            return response()->json([
                'message' =>  $err->getMessage(),  
            ], 500); // 500 status code indicates internal server error
        }
    }
}
