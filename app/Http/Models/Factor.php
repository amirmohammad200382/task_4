<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factor extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'order_id',
    ];

    public function order() {
        return $this->belongsTo( Order::class);
    }

}
