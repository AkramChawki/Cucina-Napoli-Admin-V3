<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DayTotal extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'type',
        'day',
        'month',
        'year',
        'total',
    ];

    const TYPE_CONSOMMABLE = 'consommable';
    const TYPE_CUISINE = 'cuisine';
    const TYPE_ECONOMAT = 'economat';
    const TYPE_PIZZA = 'pizza';

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }
}