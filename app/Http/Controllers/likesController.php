<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\likes;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class likesController extends Controller
{
    public function like(Request $request , $id )
    { 
        $user_id = $request->user()->id;
        $like = likes::where('product_id', $id)
        ->where('user_id' , $user_id )->first();
      
        if ($like!= null)
         { 
             
        if ($like->like == false) {
            $like->like = true;
            $like->save();
            $response = [
                'message' => 'product liked successfully ',];
            return response($response, 201);}

        if ($like->like == true)  {
            $like->like = false;
            $like->save();
            $response = [
                'message' => 'canceled like successfully ',];
            return response($response, 201);}     
            } 
                else {
                $values = $request->validate([
                    'like',
                ]);
                $like = likes::create([
                    'like' => true,
                ]);
                $like->user_id = $request->user()->id;
                $like->save();
                $like->product_id = $id;
                $like->save();
                $response = [
                    'message' => 'product liked successfully ',];
                return response($response, 201);
                $like-> increment('likes');
            }
    }
}
