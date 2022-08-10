<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class favorites extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'is_favorite',
        'image',
        'title',
        'current_price'

    ];

    public function favorite(){
        return $this->belongsTo(User::class ,  'first_name' );
        return $this->belongsTo(Product::class , 'id');
    }
}
