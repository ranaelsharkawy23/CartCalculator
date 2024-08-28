<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'Itemtype' => 'required|min:3',
            'Itemprice' => 'required|min:1|decimal:2',
            'shippingfrom' => 'required|min:2',
            'weight' => 'required|decimal:2',

            
           

           
        ];
    }
}
