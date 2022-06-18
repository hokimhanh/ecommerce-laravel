<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
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
        if(request()->routeIs('admin.sliders.store')) {
            $nameRule = 'required|string|unique:sliders|max:255';
            $imageRule = 'required|array|max:1';
        } elseif (request()->routeIs('admin.sliders.update')) {
            $id = $this->route('slider')->id;
            $nameRule ='required|string|max:255|unique:sliders,name,' . $id;
            $imageRule = 'nullable|array|max:1';
        }
        return [
            'name' => $nameRule,
            'product_id' => 'required|integer|exists:products,id',
            'image' => $imageRule,
            'old_image' => 'nullable|string',
            'image.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}
