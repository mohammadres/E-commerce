<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use Illuminate\Contracts\View\View;
use Illuminate\View\ViewFinderInterface;

class Product extends Model 
    { 
    use HasFactory ;
    
    

    protected $table ="products";

    protected $fillable =[
        'id',
        'views',
        'title',
        'contact',
        'amount',
        'category',
        'date',
        'image',
        'ispler',
        'price1',
        'price2',
        'price3',
        'user_id', 
        'user_name', 
        'current_price',
        'likes',
               
    ];
   
public function user(){
    return $this->belongsTo(User::class , 'id');
    return $this->hasMany(comments::class, 'id');
    return $this->hasMany(likes::class, 'id');
    return $this->hasMany(favorite::class, 'id');

}

}
