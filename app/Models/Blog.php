<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'user_id',
        'cover_image',
        'slug',
        'description',
        'content'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
