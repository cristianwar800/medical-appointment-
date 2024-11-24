<?php

namespace App\Http\Controllers;  // Sin cambios

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    	
			public function index()
{
    $appointments = Appointment::orderBy('appointment_time', 'desc')
        ->get()
        ->map(function ($appointment) {
            $appointment->formatted_time = Carbon::parse($appointment->appointment_time)
                ->format('d/m/Y H:i');
            return $appointment;
        });

    return view('index', compact('appointments'));
}


	public function create()
    {
        $doctors = Doctor::orderBy('name')->get();
        $appointment = new Appointment();
        $appointment->status = 'scheduled'; // Estado por defecto

        return view('form', compact('doctors', 'appointment'));
    }

    /**
     * Store a newly created appointment.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_name' => 'required|string|max:255',
            'patient_contact' => 'required|string|max:50',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_time' => 'required|date',
            'duration' => 'nullable|integer|min:1|max:480',
            'status' => 'required|in:scheduled,completed,cancelled',
            'appointment_notes' => 'nullable|string|max:1000',
        ]);

        $validated['appointment_time'] = Carbon::parse($request->appointment_time);
        
        Appointment::create($validated);

        return redirect()
            ->route('appointments.index')
            ->with('success', 'La cita ha sido creada exitosamente.');
    }

    /**
     * Display the specified appointment.
     */
    public function show(Appointment $appointment)
    {
        $appointment->load('doctor');
        
        // Asegurar que appointment_time sea una instancia de Carbon
        if ($appointment->appointment_time && !$appointment->appointment_time instanceof Carbon) {
            $appointment->appointment_time = Carbon::parse($appointment->appointment_time);
        }

        // Preparar textos de estado para la vista
        $statusTexts = [
            'scheduled' => 'Programada',
            'completed' => 'Completada',
            'cancelled' => 'Cancelada'
        ];

        $appointment->status_text = $statusTexts[$appointment->status] ?? 'Desconocido';

        return view('show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified appointment.
     */
    public function edit(Appointment $appointment)
    {
        $doctors = Doctor::orderBy('name')->get();
        
        if ($appointment->appointment_time && !$appointment->appointment_time instanceof Carbon) {
            $appointment->appointment_time = Carbon::parse($appointment->appointment_time);
        }
    
        return view('form', compact('appointment', 'doctors'));
    }
    
    /**
     * Update the specified appointment.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'patient_name' => 'required|string|max:255',
            'patient_contact' => 'required|string|max:50',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_time' => 'required|date',
            'duration' => 'nullable|integer|min:1|max:480',
            'status' => 'required|in:scheduled,completed,cancelled',
            'appointment_notes' => 'nullable|string|max:1000',
        ]);

        $validated['appointment_time'] = Carbon::parse($request->appointment_time);
        
        $appointment->update($validated);

        return redirect()
            ->route('appointments.index')
            ->with('success', 'La cita ha sido actualizada exitosamente.');
    }

    /**
     * Cancel the specified appointment.
     */
    public function cancel(Appointment $appointment)
    {
        $appointment->update(['status' => 'cancelled']);

        return redirect()
            ->route('appointments.index')
            ->with('success', 'La cita ha sido cancelada exitosamente.');
    }

    /**
     * Remove the specified appointment.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()
            ->route('appointments.index')
            ->with('success', 'La cita ha sido eliminada exitosamente.');
    }
}
