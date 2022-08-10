<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class addproduct extends FormRequest
{



    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'contact' => 'required',
            'amount' => 'required',
            'category' => 'required',
            'image' => 'required',
            'date' => 'required',
            'ispler' => 'required',
            'price1' => 'required',
            'price2' => 'required',
            'price3' => 'required'
        ];
    }
}
