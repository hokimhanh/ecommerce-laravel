<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'address',
        'phone',
        'user_id',
        'shipping_fee',
        'subtotal',
        'total',
        'status',
        'note'
    ];
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function($model) {
            if(empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid();
            }
        });
    }
    public function products()
    {
        return $this->belongsToMany(Product::class ,'order_details', 'order_id', 'product_id')
            ->withTimestamps()->withPivot(['quantity','price','options','total']);
    }
}
