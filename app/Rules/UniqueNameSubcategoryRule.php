<?php

namespace App\Rules;

use App\Models\Subcategory;
use Illuminate\Contracts\Validation\Rule;


class UniqueNameSubcategoryRule implements Rule
{
    protected $name;
    protected $category_id;
    protected $except;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($name, $category_id, $except = null)
    {
        $this->name = $name;
        $this->category_id = $category_id;
        $this->except = $except;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return !Subcategory::where([
            'name' => $this->name,
            'category_id' => $this->category_id
            ])
            ->where('id','!=',$this->except)
            ->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be unique in category.';
    }
}