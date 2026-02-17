<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_date',
        'service_name',
        'service_price',
        'status',
        'insurance_company_id',
        'paid',
        'remaining',
    ];

    protected $casts = [
        'appointment_date' => 'datetime',
        'service_price' => 'decimal:2',
        'paid' => 'decimal:2',
        'remaining' => 'decimal:2',
    ];

    /* ========= Relations ========= */

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function company()
    {
        return $this->belongsTo(InsuranceCompany::class,'insurance_company_id');
    }
}
