<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsuranceCompany extends Model
{
    use HasFactory;

    protected $table = 'insurance_companies';

    protected $fillable = [
        'name',
    ];

    /* ================= Relations ================= */

    public function prices()
    {
        return $this->hasMany(InsurancePrice::class, 'insurance_company_id');
    }

    public function patients()
    {
        return $this->hasMany(Patient::class, 'insurance_company_id');
    }
}
