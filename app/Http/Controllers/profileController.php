<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class profileController extends Controller
{

    public function user(Request $request)
    {
        $id = $request->only('id');
        $id = User::where($id, 'id')->get();
        $respons = [
            'message' => 'return successfully',
            'success' => true,
            'data' => $id,
        ];
        return response($respons, 200);
    }

    public function user_image(Request $request , $id)
    {   
        $user = User::find($id);
        if(Auth::user()->id == $user->id){
        $user->image = $request->image;
        if($user->image==null){$user->image = '';}
        $user->save();
        $respons = [
            'message' => 'return successfully',
            'success' => true,
            'data' => $user,
        ];
        return response($respons, 200);
    }
}
}
