<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        if(request()->routeIs('admin.products.store')) {
            $nameRule = 'required|string|unique:products|max:255';
            $imageRule = 'required|array|max:10';
            
        } elseif (request()->routeIs('admin.products.update')) {
            $id = $this->route('product')->id;
            $nameRule = 'required|string|max:255|unique:products,name,' . $id;
            $imageRule = 'nullable|array|max:10';
        }
        return [
            'name' => $nameRule,
            'subcategory_id' => 'required|integer|exists:subcategories,id',
            'price' => 'required|integer|min:1|max:999999999',
            'discount' =>'integer|min:1|max:100|nullable',
            'is_in_stock' => 'required|boolean',
            'description' => 'string|nullable',
            'prod_images' => $imageRule,
            'old_prod_images' => 'required|string|sometimes',
            'prod_images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'attributes' => 'required|array|sometimes',
            'attributes.*' => 'required|string|distinct'
        ];
        
    }
}