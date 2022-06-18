<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'category_id',
        'slug'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id', 'id');
    }
    public function products()
    {
        return $this->hasMany(Product::class,'subcategory_id', 'id');
    }
}
