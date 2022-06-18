<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttributeRequest extends FormRequest
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
        if(request()->routeIs('admin.attributes.store')) {
            $nameRule = 'required|string|unique:attributes|max:50';
        } elseif (request()->routeIs('admin.attributes.update')) {
            $id = $this->route('attribute')->id;
            $nameRule ='required|string|max:50|unique:attributes,name,' . $id;
        }
        return [
            'name' => $nameRule
        ];
    }
}
