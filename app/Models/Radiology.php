<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Radiology extends Model
{
    use HasFactory;

    protected $fillable = [
        'radiology_name',
        'patient_id',
        'appointment_id',
        'images',
        'notes',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
