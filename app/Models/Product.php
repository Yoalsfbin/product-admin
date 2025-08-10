<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }
    public function mainPhoto()
    {
        return $this->belongsTo(\App\Models\ProductPhoto::class, 'main_photo_id');
    }
    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }
    public function uploader()
    {
        return $this->belongsTo(\App\Models\User::class, 'uploaded_by');
    }
    public function stockHistories()
    {
        return $this->hasMany(\App\Models\StockHistory::class);
    }
    public function activities()
    {
        return $this->hasMany(\App\Models\ProductActivity::class);
    }
    public function photos()
    {
        return $this->hasMany(\App\Models\ProductPhoto::class);
    }
}
