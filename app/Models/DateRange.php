<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DateRange extends Model
{
    use HasFactory;

    protected $fillable = [
        'start',
        'end',
        'active_date_range',
        'holidays',
    ];

    protected $casts = [
        'holidays' => 'array',
    ];
}
