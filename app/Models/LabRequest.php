<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LabRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'lab_id',
        'patient_id',
        'appointment_id',
        'request_name',
        'status',
        'price',
        'paid',
        'remaining',
        'notes',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'paid' => 'decimal:2',
        'remaining' => 'decimal:2',
    ];

    /* ========= Relations ========= */

    public function lab()
    {
        return $this->belongsTo(Lab::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
