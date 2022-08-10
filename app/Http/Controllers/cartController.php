<?php

namespace App\Http\Controllers;
use Illuminate\Support\Carbon;
use App\Models\cart;
use App\Models\Product;
use App\Http\Controllers\ProductsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class cartController extends Controller
{
    public function AddToCart(Request $request, $id)
    {

        $user_id = $request->user()->id;
        $Add = cart::where('product_id', $id)
            ->where('user_id', $user_id)->first();
            $product=Product::where('id' , $id)->first();
            $amount=$product->amount;
        if ($Add == null) {
    
            $values = $request->validate([

                'quantity'=> 'required'  ,

            ]);
            if($values['quantity']> $amount){  $response = [
                'message' => 'cant add amount',
            ];
            return response($response, 201);  }
            $product->amount=$product->amount-$values['quantity'];
            $product->save();
            $like = cart::create([
                'user_id' => $user_id,
                'product_id' =>   $id,
                'image'   =>    $product->image ,
                'product_title' =>   $product->title ,
                'price'      =>  $product->current_price ,
                'quantity'   =>   $values['quantity'],
              

            ]);
            $like->total_price = ($product->current_price*$values['quantity']);
            $like->save();
            $response = [
                'message' => 'product added to cart successfully ',
            ];
            return response($response, 201);
            
        }
        else {
            $response = [
                'message' => 'product already  added to cart ,do you want increased the quantity by one ',
            ];
            $Add->total_price = ($Add->price*$Add->quantity);
            $Add->save();
            return response($response, 201);
           

        }
    }

    public function ShowCart(Request $request){
        $user_id=$request->user()->id;
        $de=Product::all('id')->last();
        if($de!=null){
            $f=$de->id;
            for($j=1;$j<=$f;$j++){
            $this->price($f);}        
         }
        $product=cart::where('user_id', $user_id)->get();
        if(!$product->count()){return  $response =[
            'message' => 'no items in cart',
            'data' => $product,
            'items' => 0 ,
            'totalPriceAll' => 0,
         ]; 
         return response($response, 200); }
        $items=cart::where('user_id', $user_id)->count();
        $totalPriceAll=cart::all('id')->last();
        $totalprice=0;
        if($totalPriceAll==null){ return  $totalprice=0 ;  }
        else{
        $id=$totalPriceAll->id;
        for($i=1;$i<=$id;$i++){
            $t=cart::where('id', $i)->first();
            if($t!=null){
            if($user_id == $t->user_id){
            $totalprice=$totalprice +$t->total_price;
            } 
        }
        }
    }
        return  $response =[
            'message' => 'get product successful',
            'success' => true,
            'data' => $product  ,
            'items' => $items ,
            'totalPriceAll' => $totalprice,
         ]; 
         return response($response, 200);
        // $totalprice=0;
    }

    public function DeleteItem(Request $request){
        $id=$request->only('id');
        $delete=cart::where('id',$id)->first();
        $id_product=$delete->product_id;
        if($delete!=null){
            $delete->delete();

            $product_amount=Product::where('id',$id_product)->first();
            $product_amount->amount=$product_amount->amount + $delete->quantity;
            $product_amount->save();
            $response = [
                'message' => 'product removed from cart successfully',
                'success' => true ];
            return response($response, 200);        
            }
            else { return 'no';}
    }







    public function price($id){
        $current=Product::where('id', $id)->first();
        if($current!=null){
           $date=Carbon::now(); 
           $EXdate=$current->date;
            
            $to=carbon::createFromFormat('Y-m-d', $EXdate);
            $diff_in_days= $to->diffInDays($date);
            if($diff_in_days>30){
                $current->current_price = $current->price1;
                $current->save();
            }
            if($diff_in_days<=30 && $diff_in_days>15){
                $current->current_price = $current->price2;
                $current->save();
            }
            if($diff_in_days<=15){
                $current->current_price = $current->price3;
                $current->save();
            }

       return $current->current_price ; }
    }



}
