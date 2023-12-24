<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'price',
        'inventory',
        'description',
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('count');
    }
}
