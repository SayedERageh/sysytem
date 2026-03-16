<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
protected $fillable = [
    'patient_id',
    'appointment_id',
    'name',
    'notes',
    'images',
    'approved',
];

protected $casts = [
    'images' => 'array',
    'approved' => 'boolean',
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

