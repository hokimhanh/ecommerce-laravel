<?php

namespace App\Http\Requests;

use App\Rules\UniqueNameSubcategoryRule;
use Illuminate\Foundation\Http\FormRequest;

class SubcategoryRequest extends FormRequest
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
        if(request()->routeIs('admin.subcategories.store')) {
            $nameRule = ['required','string',new UniqueNameSubcategoryRule($this->name,$this->category_id)];
        } elseif (request()->routeIs('admin.subcategories.update')) {
            $id = $this->route('subcategory')->id;
            $nameRule =['required','string',new UniqueNameSubcategoryRule($this->name,$this->category_id,$id)];
        }
        return [
            'name' => $nameRule,
            'category_id' => 'required|integer|exists:categories,id'
        ];
    }
}
