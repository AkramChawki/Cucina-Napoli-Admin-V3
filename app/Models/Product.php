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
        "restaurant",
        "text",
        "image",
        "price",
        "is_formule",
        "category_id",
        "IDCaisse",
    ];

    protected $casts = [
        'restaurant' => 'array',
        'is_formule' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    /**
     * Get the formule options configuration
     */
    public function getFormuleOptionsAttribute()
    {
        // Define formule options based on product name
        if (str_contains(strtolower($this->name), 'formule 1') || 
            str_contains(strtolower($this->name), 'formule 2') || 
            str_contains(strtolower($this->name), 'formule 3')) {
            return [
                [
                    'id' => 1,
                    'name' => 'Nem au choix',
                    'required' => true,
                    'max_selections' => 1,
                    'items' => [
                        ['id' => 581, 'name' => 'Nem Legume', 'price_adjustment' => 0],
                        ['id' => 582, 'name' => 'Nem Viande Hache', 'price_adjustment' => 0],
                        ['id' => 583, 'name' => 'Nem Poulet', 'price_adjustment' => 0],
                    ]
                ],
                [
                    'id' => 2,
                    'name' => 'Jus au choix',
                    'required' => true,
                    'max_selections' => 1,
                    'items' => [
                        ['id' => 52, 'name' => 'Jus Orange', 'price_adjustment' => 0],
                        ['id' => 53, 'name' => 'Jus Betravino', 'price_adjustment' => 0],
                        ['id' => 569, 'name' => 'Jus Fraise', 'price_adjustment' => 0],
                    ]
                ]
            ];
        } 
        else if (str_contains(strtolower($this->name), 'formule pizza')) {
            return [
                [
                    'id' => 1,
                    'name' => 'Nem au choix',
                    'required' => true,
                    'max_selections' => 1,
                    'items' => [
                        ['id' => 581, 'name' => 'Nem Legume', 'price_adjustment' => 0],
                        ['id' => 582, 'name' => 'Nem Viande Hache', 'price_adjustment' => 0],
                        ['id' => 583, 'name' => 'Nem Poulet', 'price_adjustment' => 0],
                    ]
                ],
                [
                    'id' => 2,
                    'name' => 'Jus au choix',
                    'required' => true,
                    'max_selections' => 1,
                    'items' => [
                        ['id' => 52, 'name' => 'Jus Orange', 'price_adjustment' => 0],
                        ['id' => 53, 'name' => 'Jus Betravino', 'price_adjustment' => 0],
                        ['id' => 569, 'name' => 'Jus Fraise', 'price_adjustment' => 0],
                    ]
                ],
                [
                    'id' => 3,
                    'name' => 'Pizza classique au choix',
                    'required' => true,
                    'max_selections' => 1,
                    'items' => [
                        ['id' => 39, 'name' => 'Margarita', 'price_adjustment' => 0],
                        ['id' => 40, 'name' => 'Tunara', 'price_adjustment' => 0],
                        ['id' => 41, 'name' => 'Funghi', 'price_adjustment' => 0],
                        ['id' => 42, 'name' => 'Verdura', 'price_adjustment' => 0],
                        ['id' => 43, 'name' => 'Caprese', 'price_adjustment' => 0],
                        ['id' => 44, 'name' => 'Peperoni', 'price_adjustment' => 0],
                    ]
                ]
            ];
        }
        else if (str_contains(strtolower($this->name), 'formule shour')) {
            return [
                [
                    'id' => 1,
                    'name' => 'Pizza classique au choix',
                    'required' => true,
                    'max_selections' => 1,
                    'items' => [
                        ['id' => 39, 'name' => 'Margarita', 'price_adjustment' => 0],
                        ['id' => 40, 'name' => 'Tunara', 'price_adjustment' => 0],
                        ['id' => 41, 'name' => 'Funghi', 'price_adjustment' => 0],
                        ['id' => 42, 'name' => 'Verdura', 'price_adjustment' => 0],
                        ['id' => 43, 'name' => 'Caprese', 'price_adjustment' => 0],
                        ['id' => 44, 'name' => 'Peperoni', 'price_adjustment' => 0],
                    ]
                ]
            ];
        }
        
        return [];
    }
}