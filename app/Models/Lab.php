<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lab extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'paid',
        'remaining',
    ];

    protected $casts = [
        'paid' => 'decimal:2',
        'remaining' => 'decimal:2',
    ];

    public function requests()
    {
        return $this->hasMany(LabRequest::class);
    }
}
