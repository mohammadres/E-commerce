<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use Illuminate\Http\Request;
use Nette\Utils\Image;
use App\Http\Requests\addproduct;
use Illuminate\Contracts\Filesystem\Filesystem;

use App\Models\User;
use App\Models\likes;
use App\Models\favorites;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\comments;
use App\Http\Controllers\commentsController;
use Dotenv\Store\File\Paths;
use Facade\FlareClient\Api;
use Illuminate\Foundation\Http\FormRequest;
use pathinfo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Storage;
use PhpParser\Comment;
use Symfony\Component\Mime\Header\PathHeader;
use Illuminate\Support\Carbon;
class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /////////////// Add products  ///////////////
        public function addproduct(addproduct $request)
    {

        $product = Product::create($request->all());
        $product->user_id=$request->user()->id;
        $product->save();
        $product->user_name=$request->user()->first_name . ' ' . $request->user()->last_name;
        $product->save();
        $de=Product::all('id')->last();
        if($de!=null){
            $f=$de->id;
            for($j=1;$j<=$f;$j++){
            $this->price($f);}
         }
        $response = [
            'message' => 'add product successful ',
            'success' => true,
            'data' =>  [$product] ];
        return response($response, 201);

    }

            ////////// Update product /////////
    public function update(Request $request , $id)
    {

        $product = Product::find($id);
        if(Auth::user()->id == $product->user_id){
        $product -> update($request->all());
        $response = [
            'message' => 'product updated successful',
            'success' => true ];
        return response($response, 200);
        }
    else {$response = [
        'message' => 'product not updated , this product belong to another user',
        'success' => false ];
    return response($response, 404);
     }
    }

            /////////// Delete product ////////////
    public function delete(Request $request)
    {
        $id = request()->only('id');
        $delete = Product::whereId($id)->firstOrFail();
        if(Auth::user()->id == $delete->user_id)
        {
            $delete->delete();
            $response = [
                'message' => 'product deleted successful',
                'success' => true ];
            return response($response, 202);
        }
        else {$response = [
            'message' => 'product not deleted , this product belong to another user',
            'success' => false ];
        return response($response, 400);
         }
    }
         ///////// Get the product by id (show product detailes) //////////
    public function show(Request $request)
    {  $user_id=$request->user()->id ;
        $id = request()->only('id');
        $this->price($id);
        $product = Product::where('id', $id)->first();
        $comment=comments::where('product_id', $id)->get();
        $lik=likes::all('id')->last();
        if($lik!=null){
        $li=$lik->id;
        $product->likes_counter=0;
        $product->save();
            for($i=1;$i<=$li;$i++){

                $like=likes::where('id', $i)->first();
                if($like!=null){
                if($like->product_id == $product->id){

                if ($like->like == true) {
                    $product->likes_counter++;
                    $product->save();}}}}}

        $show = Product::whereId($id)->firstOrFail();
        $show -> increment('views');
        $get = Product::whereId($id)->get();
        return  $response =[
            'message' => 'get product successful',
            'success' => true,
            'data' => $get  ,
            'comment' => $comment ,

         ];
         return response($response, 200);

    }

        //////// Get All products /////
    public function index(Request $request)
    {
         $response1= [ ];
        $user_id=$request->user()->id;
        $de=Product::all('id')->last();
        if($de==null){
            return  $response =[
                'message' => "there is no product",
                    'status' => false,
                    'data' =>  $response1 ,

            ];
             return response($response, 400);
         }
         $f=$de->id;
        for($j=1;$j<=$f;$j++){
        $this->price($f);}
        $li=likes::all('id')->last();
        if($li==null){    }
        else{
        $l=$li->id;
        for($i=1 ; $i<=$f ; $i++){
        $comment=comments::where('product_id', $i)->get();
        if($a=Product::where('id', $i)->first()!=null){
        $product = Product::where('id', $i)->first();
          $response1 =['comment' => $comment ];
       // return response($response1, 200);
            $like=likes::where('product_id', $i)->where('user_id', $user_id )->first();
           if($like!=null){
            if ($like->like == false) {
                $product->likes = 'false';
                $product->save();
                }

                if ($like->like == true) {
                  $product->likes = 'true';
                  $product->save();
                    }
                }
                else{
                    $product->likes = 'false';
                    $product->save();
                }
                $favorite=favorites::where('product_id', $i)->where('user_id', $user_id )->first();
                if($favorite!=null){
                    if ($favorite->is_favorite == false) {
                        $product->is_favorite = 'false';
                        $product->save();
                        }

                        if ($favorite->is_favorite == true) {
                            $product->is_favorite = 'true';
                            $product->save();
                            }
                        }
                        else{
                          $product->is_favorite = 'false';
                          $product->save();
                        }
            }



       }
    }



       $data=Product::all();
         $response =[
            'message' => 'all products',
            'success' => true,
            'data' => $data,

         ];
         return response($response, 200 , );
        }

        ////////////Sort products by titlae OR price /////////
    public function sort(Request $request)
     {
        $sort = $request->sort;
         switch ($sort) {
             case 'title': $case =  Product::orderBy('title', 'asc')->get();
             break;
             case 'price': $case =  Product::orderBy('current_price', 'asc')->get();
             break;
         }
        $response =[ 'message' => 'product sorted successfully' ,
        'success' => true,
        'data' => $case
     ];
     return response($response, 200);

    }

        //////////// Search product By name ////////
    public function search_by_name(Request $request)
    {
            $product=$request->only('title');
            $product=Product::
            where('title' , 'like' , '%' .$request->input('title') . '%')->get();

            $response = [
                'message' => 'product search successful',
                'success' => true,
                'data'=> $product,
            ];

            return response($response, 200);

        }

            //////////// Search product By date ////////
        public function search_by_date(Request $request)
        {
                $product=$request->only('date');
                $product=Product::
                where('date' , 'like' , '%' .$request->input('date') . '%')->get();
            $response = [
                'message' => 'product search successful',
                'success' => true,
                'data'=> $product,
            ];

            return response($response, 200);

            }

            //////// Get the popular products /////////
        public function popular()
        {

        $ispler = Product::where('ispler', 'true')->get();
        if ($ispler->count()){
        $response =[
            'message' => 'all popular products',
            'success' => true,
            'data' => $ispler
         ];
         return response($response, 200);
        }
         else {  $response =[
            'message' => 'popular products not found',
            'success' => false,
            'data' => $ispler
         ];
         return response($response, 200);
          }


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

