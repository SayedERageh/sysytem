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
        'diagnosis_chart',   // جديد
        'teeth_number',      // جديد
        'teeth_length',      // جديد
        'next_session',      // جديد
        'notes',  
        'approval_difference'  ,         // جديد
        'payment_method'  ,         // جديد
    ];

    protected $casts = [
        'appointment_date' => 'datetime',
        'service_price'    => 'decimal:2',
        'paid'             => 'decimal:2',
        'remaining'        => 'decimal:2',
        'diagnosis_chart'  => 'array', // تحويل JSON تلقائيًا إلى مصفوفة
        'teeth_number'     => 'array', // تحويل JSON تلقائيًا إلى مصفوفة
    ];

    /* ========= Relations ========= */
protected $attributes = [
    'service_name' => 'كشف \ متابعة',
    'service_price' => 0,
];
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
        return $this->belongsTo(InsuranceCompany::class, 'insurance_company_id');
    }

    public function insurancePrice()
    {
        return $this->belongsTo(InsurancePrice::class, 'insurance_price_id');
    }

    public function labRequests()
    {
        return $this->hasMany(LabRequest::class);
    }
    
}