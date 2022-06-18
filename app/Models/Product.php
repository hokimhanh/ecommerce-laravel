<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'subcategory_id',
        'price',
        'discount',
        'is_in_stock',
        'description',
        'image_list'
    ];
    
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class,'subcategory_id', 'id');
    }
    public function attributes()
    {
        return $this->belongsToMany(
            Attribute::class,'attribute_values','product_id','attribute_id')
            ->withPivot('value')->withTimestamps();
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class ,'order_details', 'product_id', 'order_id');
    }
    // Scope query category
    public function scopeFindByCategoryId($query, $categoryId)
    {
        return $query->whereHas('subcategory.category', function ($query) use ($categoryId) {
            $query->where('id', $categoryId);
        });
    }
    // Scope query subcategory
    public function scopeFindBySubcategoryId($query, $subcategoryId)
    {
        return $query->whereHas('subcategory', function ($query) use ($subcategoryId) {
            $query->where('id', $subcategoryId);
        });
    }
    // Scope sort by
    public function scopeSort($query, $request)
    {
        if ($request->input('sort') == 'azSort') {
           $query->orderBy('name');
        };
        if ($request->input('sort') == 'zaSort') {
           $query->orderByDesc('name');
        };
        if ($request->input('sort') == 'lPrice') {
           $query->orderBy('price');
        };
        if ($request->input('sort') == 'hPrice') {
           $query->orderByDesc('price');
        };
        if ($request->input('sort') == 'default') {
           $query->latest();
        };
    }
    // Scope price range
    public function scopePrice($query, $request)
    {
        if ($request->price) {
           $query->whereBetween('price',explode('-',$request->price));
        };
    }
    // Scope color
    public function scopeColor($query, $request)
    {
        if ($request->colors) {
            $query->whereHas('attributes', function ($query) use ($request) {
                $query->whereJsonContains('value', explode(',',$request->colors));
            });
        };
    }
    // Scope name
    public function scopeName($query, $request)
    {
        if ($request->q) {
           $query->where('name', 'like', '%'. $request->q .'%');
        };
    }

}