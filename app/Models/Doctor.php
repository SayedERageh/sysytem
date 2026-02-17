<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $table = 'doctors';

    protected $fillable = [
        'name',
        'phone',
        'image',
        'working_hours',
    ];

    protected $casts = [
        'working_hours' => 'array',
    ];
}
