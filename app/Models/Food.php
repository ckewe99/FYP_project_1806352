<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $table = "food";

    protected $fillable = [
        'name',
        'price',
        'session',
        'days',
        // 'type',
        'dessert',
        // 'start',
        // 'end',
        'date_range_id',
        'stall_id',
    ];
}
