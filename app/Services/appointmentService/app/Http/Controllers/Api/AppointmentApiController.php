<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentApiController extends Controller
{
    public function index()
    {
        $appointments = Appointment::all(); // Modifica según necesidades específicas
        return response()->json($appointments);
    }

    public function store(Request $request)
    {
        $appointment = Appointment::create($request->all()); // Asegúrate de validar y desinfectar adecuadamente
        return response()->json($appointment, 201);
    }

    public function show(Appointment $appointment)
    {
        return response()->json($appointment);
    }

    public function update(Request $request, Appointment $appointment)
    {
        $appointment->update($request->all());
        return response()->json($appointment);
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $data = $request->validate(['status' => 'required|in:scheduled,completed,cancelled']);
        $appointment->update($data);
        return response()->json($appointment);
    }
}
