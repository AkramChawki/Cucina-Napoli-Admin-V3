<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'created_at' => 'date:M j, Y',
        'updated_at' => 'date:M j, Y',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restau_id');
    }

    public function items()
    {
        return $this->hasMany(OrderLine::class);
    }
}
