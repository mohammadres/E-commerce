<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('views')->default(0);
            $table->foreignId('user_id')->nullable();
            $table->string('user_name')->nullable();    
            $table->string('title')->require;
            $table->string('contact')->require;
            $table->string('price1')->nullable();
            $table->string('price2')->nullable();
            $table->string('price3')->nullable();
            $table->string('current_price')->nullable();
            $table->string('image')->nullable();
            $table->string('ispler')->nullable();
            $table->string('category')->nullable();
            $table->date('date')->nullable();
            $table->string('amount')->nullable();
            $table->string('likes')->default(0);
            $table->string('likes_counter')->default(0);
            $table->string('is_favorite')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
