<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
        if(request()->routeIs('front.purchase.store')) {
            return [
                'name' => 'required|string|max:150',
                'phone' => 'required|numeric|digits:10',
                'address'=> 'required|string|max:255',
                'state' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'note' => 'string|nullable|max:255'
            ];
        } elseif (request()->routeIs('admin.categories.update')) {
            $id = $this->route('category')->id;
            $nameRule ='required|string|max:255|unique:categories,name,' . $id;
        }
       
    }
}
