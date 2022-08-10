<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use App\Models\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $values = $request->validate([

            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed|min:8'
        ]);

        $user = User::create([
            'first_name' => $values['first_name'],
            'last_name' => $values['last_name'],
            'email' => $values['email'],
            'password' => bcrypt($values['password'])
        ]);

        $token = $user->createToken('myAccessToken')->plainTextToken;


        $response = [
            'message' => 'signup successful',
            'success' => true,
            'user' => $user,
            'token' => $token

        ];

        return response($response, 201);
    }


    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response(['message' => 'login failed'], 401);
        }

        $token = $user->createToken('myAccessToken')->plainTextToken;
        $user->image = $request->image;
        if($user->image==null){$user->image = '';}
        $response = [
            'message' => 'login successful', 'success' => true,
            'data' => [$user], 'token' => $token
        ];
        return response($response, 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'logged Out successful'], 200);
    }

    public function forgetpassword(Request $request){

    }


    public function resetPassword(){
        
    }

}
