<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'DDN',
        'telephone',
        'address',
        'city',
        'country',
        'marital_status',
        'username',
        'profile_photo',
        'id_card_front',
        'id_card_back',
        'restau',
        'embauche',
        'depart'
    ];

    protected $dates = ['DDN', 'embauche', 'depart'];
}
