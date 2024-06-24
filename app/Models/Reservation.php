<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'nom',
        'prenom',
        'telephone',
        'email',
        'selectedDate',
        'restau',
        'notes',
        'confirmed',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
