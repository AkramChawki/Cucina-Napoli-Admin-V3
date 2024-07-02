<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "sub_name",
        "slug",
        "text",
        "image",
        "price",
        "category_id",
        "restaurant",
        "IDCaisse",
        "visible",
    ];

    protected $casts = [
        "restaurant" => "array",
        "visible" => "boolean"
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
