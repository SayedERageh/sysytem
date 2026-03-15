<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeethProcedure extends Model
{
    protected $fillable = [
        'patient_id',   // ربط بالزيارة
        'tooth_number',     //  من النوع جيسون علشان اضسف كا سنه علي شكل تاج في الفمنت رقم السن
                'appointment_id',

        'procedure',        // الإجراء الحالي
        'notes',            // ملاحظات الإجراء الحالي
        'next_procedure',   // الإجراء المخطط للزيارة القادمة
        'next_notes',       // ملاحظات الزيارة القادمة
        'w_l',              // طول العصب
    ];

    protected $casts = [
        'tooth_number' => 'integer',
        'w_l' => 'float',
    ];
    
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}