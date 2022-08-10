<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class likes extends Model
{
    use HasFactory;

    protected $fillable =[
        'like',
        'user_id',
        'product_id',
    ];



    public function likes(){
        return $this->belongsTo(User::class ,  'id' );
        return $this->belongsTo(Product::class , 'id');
    }


}
