<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeethProcedure extends Model
{
    protected $fillable = [
        'patient_id',   // ربط بالزيارة
        'tooth_number',     // رقم السن
        'procedure',        // الإجراء الحالي
        'notes',            // ملاحظات الإجراء الحالي
        'next_procedure',   // الإجراء المخطط للزيارة القادمة
        'next_notes',       // ملاحظات الزيارة القادمة
        'w_l',              // طول العصب
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}