<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patients';

    protected $fillable = [
        'name',
        'phone',
        'insurance_number',
        'insurance_company_id',
        'file_number',
        'remaining_amount',
        'age',
    ];

    protected $casts = [
        'remaining_amount' => 'decimal:2',
        'age'              => 'integer',
    ];

    /* ================= Relations ================= */

    public function company()
    {
        return $this->belongsTo(InsuranceCompany::class, 'insurance_company_id');
    }
    public function appointments()
{
    return $this->hasMany(Appointment::class);
}

public function labRequests()
{
    return $this->hasMany(\App\Models\LabRequest::class);
}
public function radiologies()
{
    return $this->hasMany(Radiology::class);
}
public function approvals()
{
    return $this->hasMany(Approval::class);
}
}
