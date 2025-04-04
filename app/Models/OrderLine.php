<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'selected_options' => 'array',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
