<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\comments;

class commentsController extends Controller
{
    public function comment(Request $request, $id)
    {

        $values = $request->validate([
            'comment' => 'max:256',
        ]);

        $comment = comments::create([
            'comment' => $values['comment'],
        ]);
        $comment->user_name = $request->user()->first_name . ' ' . $request->user()->last_name;
        $comment->save();
        $comment->product_id = $id;
        $comment->save();

        $response = [
            'message' => 'comment added successfully',
            'success' => true,
            'comment' =>  $comment,
        ];

        return response($response, 201);
    }
}
