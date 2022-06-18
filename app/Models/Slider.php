<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'product_id',
        'image'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
