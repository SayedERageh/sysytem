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
}
