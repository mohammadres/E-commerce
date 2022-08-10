<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\str;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $Product_name= $this->faker->unique()->words($nb=4,$asText=true);
        $slug =str::slug($Product_name);

        return [
            'name'=>$Product_name,
            'slug'=> $slug,
            'price1'=>$this->faker->numberBetween(10,1000),
            'amount'=>$this->faker->numberBetween(5,100),
            'category'=>$this->faker->text(200),
            'ispler'=>$this->faker->boolean(false),
            'image'=>'mob'.$this->faker->unique()->numberBetween(0,22).'jpg'
        ];
    }
}
