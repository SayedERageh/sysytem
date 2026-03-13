<?php
namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\TeethProcedure;
use Illuminate\Http\Request;

class TeethProcedureController extends Controller
{
    public function index($patientId)
    {
        $patient = Patient::findOrFail($patientId);
        $teethProcedures = TeethProcedure::where('patient_id', $patientId)->get();

        return view('teeth', [
            'patient' => $patient,
            'teethProcedures' => $teethProcedures,
        ]);
    }

    // حفظ أو تحديث الإجراء
    public function update(Request $request, $patientId)
    {
        $data = $request->validate([
            'tooth_number'    => 'required|integer',
            'procedure'       => 'nullable|string',
            'notes'           => 'nullable|string',
            'next_procedure'  => 'nullable|string',
            'next_notes'      => 'nullable|string',
            'w_l'             => 'nullable|string|max:5',
        ]);

        $data['patient_id'] = $patientId;

        // لو السن موجود بالفعل، نحدثه، وإلا نضيفه جديد
        $teethProcedure = TeethProcedure::updateOrCreate(
            [
                'patient_id' => $patientId,
                'tooth_number' => $data['tooth_number']
            ],
            $data
        );

        return response()->json([
            'success' => true,
            'teethProcedure' => $teethProcedure
        ]);
    }
}