<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
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
        if(request()->routeIs('admin.blogs.store')) {
            $titleRule = 'required|string|unique:blogs|max:255';
            $imageRule = 'required|array|max:1';
        } elseif (request()->routeIs('admin.blogs.update')) {
            $id = $this->route('blog')->id;
            $titleRule ='required|string|max:255|unique:blogs,title,' . $id;
            $imageRule = 'nullable|array|max:1';
        }
        return [
            'title' => $titleRule,
            'cover_image' => $imageRule,
            'old_cover_image' => 'required|string|sometimes',
            'cover_image.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'description' =>'required|string|max:255',
            'content' =>'required|string'
        ];
    }
}
