<?php

namespace App\Http\Controllers;

use App\Models\favorites;
use App\Models\Product;
use Illuminate\Http\Request;

class favoritesController extends Controller
{
    public function favorite(Request $request, $id)
    {
        $user_id = $request->user()->id;
        $product=Product::where('id', $id)->first();
        $favorite = favorites::where('product_id', $id)
            ->where('user_id', $user_id)->first();

        if ($favorite != null) {
            if ($favorite->is_favorite == 'false') {
                $favorite->is_favorite = 'true';
                $favorite->save();
                $response = [
                    'message' => 'product added to favorite successfully ',
                ];
                return response($response, 201);
            }

            if ($favorite->is_favorite == 'true') {
                $favorite->is_favorite = 'false';
                $favorite->save();
                $response = [
                    'message' => 'product  removed from favorite successfully ',
                ];
                return response($response, 201);
            }
        } else {
            $values = $request->validate([
                'is_favorite',
            ]);
            $favorite = favorites::create([
                'is_favorite' => 'true',
            ]);
            $favorite->user_id = $request->user()->id;
            $favorite->save();
            $favorite->product_id = $id;
            $favorite->save();
            $favorite->current_price = $product->current_price;
            $favorite->save();
            $favorite->title = $product->title;
            $favorite->save();
            $favorite->image = $product->image;
            $favorite->save();
            
            $response = [
                'message' => 'product added to favorite successfully ',
            ];
            return response($response, 201);
        }
    }

    public function getfavorite(Request $request)
    {
    $user_id = $request->user()->id;
    $favorite = favorites::where('is_favorite', 'true')
    ->where('user_id' , $user_id)->get();
    if ($favorite->count()){
    $response =[
        'message' => 'all favorite products',
        'success' => true,
        'data' => $favorite
     ]; 
     return response($response, 200);
    }
     else {  $response =[
        'message' => 'favorite products not found',
        'success' => false,
        'data' => $favorite
     ]; 
     return response($response, 200);
      }
}












   /* public function getfavorite(Request $request)
    {
    $user_id = $request->user()->id;
    $l=favorites::all('id')->last();
    $f=$l->id;
        for($i=1;$i<=$f;$i++){
            $favorite = favorites::where('id',$i)->where('is_favorite', true)
            ->where('user_id' , $user_id)->get('product_id');
            if ($favorite!=null){
            $favoriteproduct=Product::where('id',$favorite)->get();
            
    }
     else {  $response =[
        'message' => 'favorite products not found',
        'success' => false,
        'data' => $favorite
     ];           return response($response, 200);

}$response =[
    'message' => 'all favorite products',
    'success' => true,
    'data' => $favoriteproduct]; 
  return response($response, 200);
  
} 

}*/
}