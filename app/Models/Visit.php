<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    // الحقول اللي مسموح تعبيتها بشكل جماعي
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'name',
        'start',
    ];

    // علاقة زيارة بالمريض
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // علاقة زيارة بالدكتور
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}