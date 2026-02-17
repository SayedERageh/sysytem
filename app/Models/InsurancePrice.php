<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsurancePrice extends Model
{
    use HasFactory;

    protected $table = 'insurance_prices';

    protected $fillable = [
        'service_name',
        'service_price',
        'insurance_company_id',
    ];

    protected $casts = [
        'service_price' => 'decimal:2',
    ];

    /* ================= Relations ================= */

    public function company()
    {
        return $this->belongsTo(InsuranceCompany::class, 'insurance_company_id');
    }
}
