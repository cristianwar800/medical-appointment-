<?php

namespace App\Services\Citas\Controllers;
use App\Http\Controllers\Controller;
use App\Services\Citas\Models\Appointment;
use App\Services\Citas\Models\Doctor;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    // Muestra la lista de citas
    public function index()
    {
        $appointments = Appointment::all();
        return view('citas::index', compact('appointments'));
    }

    // Muestra el formulario para crear una nueva cita
    public function create()
    {
        $doctors = Doctor::all(); // Obtiene todos los doctores para el formulario
        return view('citas::form', compact('doctors'));
    }

    // Almacena una nueva cita en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'patient_name' => 'required|string',
            'patient_contact' => 'required|string',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_time' => 'required|date',
            'duration' => 'nullable|integer',
            'status' => 'required|string',
            'appointment_notes' => 'nullable|string',
        ]);

        Appointment::create($request->all());

        return redirect()->route('appointments.index')->with('success', 'Appointment created successfully.');
    }

    // Muestra el formulario para editar una cita existente
    public function edit(Appointment $appointment)
    {
        $doctors = Doctor::all(); // Obtiene todos los doctores para el formulario

        // Verificar si appointment_time no es una instancia de Carbon y establecerla a now() si está vacía
        if (!$appointment->appointment_time instanceof Carbon) {
            $appointment->appointment_time = Carbon::now();
        }

        return view('citas::form', compact('appointment', 'doctors'));
    }

    // Actualiza una cita existente en la base de datos
    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'patient_name' => 'required|string',
            'patient_contact' => 'required|string',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_time' => 'required|date',
            'duration' => 'nullable|integer',
            'status' => 'required|string',
            'appointment_notes' => 'nullable|string',
        ]);

        $appointment->update($request->all());

        return redirect()->route('appointments.index')->with('success', 'Appointment updated successfully.');
    }

    // Muestra una cita específica
    public function show(Appointment $appointment)
    {
        return view('citas::show', compact('appointment'));
    }

    // Elimina una cita de la base de datos
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('appointments.index')->with('success', 'Appointment deleted successfully.');
    }
}
