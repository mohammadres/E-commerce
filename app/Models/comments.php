<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comments extends Model
{
    use HasFactory;
    protected $fillable = [
        'comment',
        'user_id',
        'product_id',
    ];



public function comment(){
    return $this->belongsTo(User::class ,  'first_name' );
    return $this->belongsTo(Product::class , 'id');
}

}
