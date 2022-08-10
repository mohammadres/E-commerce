<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function Category(Request $request){
        $category=$request->only('category');
        $medo= Product::where('category' , $category)->get();
        return  $response =[
            'message' => 'get product by category',
            'success' => true,
            'data' => $medo 
         ]; 
         return response($response, 200);
            
    }
}
