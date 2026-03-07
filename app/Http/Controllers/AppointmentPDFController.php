<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentPDFController extends Controller
{
    public function show($id)
    {
        // جلب بيانات الحجز مع العلاقات
        $appointment = Appointment::with(['patient', 'doctor', 'company'])->findOrFail($id);

        // عرض البيانات في صفحة عادية بدل PDF
        return view('pdf.appointment', compact('appointment'));
    }
}