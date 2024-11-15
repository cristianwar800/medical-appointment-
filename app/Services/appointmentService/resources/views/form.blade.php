@extends('layouts.app')

@section('styles')
<style>
    /* Base Styles */
    .appointment-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 2rem;
        border-radius: 12px;
        background-color: #ffffff;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .appointment-title {
        color: #2d3748;
        font-size: 1.875rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        border-bottom: 2px solid #e2e8f0;
        padding-bottom: 0.75rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #4a5568;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.375rem;
        font-size: 1rem;
        transition: all 0.2s ease;
        background-color: #fff;
    }

    .form-control:focus {
        border-color: #4299e1;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.2);
        outline: none;
    }

    .form-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 0.375rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .btn-primary {
        background-color: #4299e1;
        border: none;
        color: white;
    }

    .btn-primary:hover {
        background-color: #3182ce;
        transform: translateY(-1px);
    }

    .btn-warning {
        background-color: #ed8936;
        border: none;
        color: white;
    }

    .btn-warning:hover {
        background-color: #dd6b20;
        transform: translateY(-1px);
    }

    /* Dark Mode Styles */
    body.dark-mode .appointment-container {
        background-color: #2d3748;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
    }

    body.dark-mode .appointment-title {
        color: #e2e8f0;
        border-bottom-color: #4a5568;
    }

    body.dark-mode .form-label {
        color: #e2e8f0;
    }

    body.dark-mode .form-control {
        background-color: #4a5568;
        border-color: #718096;
        color: #e2e8f0;
    }

    body.dark-mode .form-control:focus {
        border-color: #63b3ed;
        box-shadow: 0 0 0 3px rgba(99, 179, 237, 0.2);
    }

    body.dark-mode .form-control::placeholder {
        color: #a0aec0;
    }

    body.dark-mode .form-select {
        background-color: #4a5568;
        color: #e2e8f0;
    }

    body.dark-mode .card {
        background-color: #2d3748;
        border-color: #4a5568;
    }

    body.dark-mode .card-title {
        color: #e2e8f0;
    }

    body.dark-mode .text-muted {
        color: #a0aec0 !important;
    }

    body.dark-mode .card-text {
        color: #e2e8f0;
    }

    /* Status Badge Styles */
    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 600;
        display: inline-block;
    }

    .status-scheduled {
        background-color: #ebf8ff;
        color: #2b6cb0;
    }

    .status-completed {
        background-color: #f0fff4;
        color: #2f855a;
    }

    .status-cancelled {
        background-color: #fff5f5;
        color: #c53030;
    }

    body.dark-mode .status-scheduled {
        background-color: #2c5282;
        color: #bee3f8;
    }

    body.dark-mode .status-completed {
        background-color: #276749;
        color: #c6f6d5;
    }

    body.dark-mode .status-cancelled {
        background-color: #9b2c2c;
        color: #fed7d7;
    }
</style>
@endsection

@section('content')
<div class="appointment-container">
    <h1 class="appointment-title">{{ isset($appointment) ? 'Editar Cita' : 'Crear Cita' }}</h1>
    
    <form action="{{ isset($appointment) && $appointment->exists ? route('appointments.update', ['appointment' => $appointment->id]) : route('appointments.store') }}" method="POST">
        @csrf
        @if(isset($appointment))
            @method('PUT')
        @endif

        <div class="form-group">
            <label class="form-label" for="patient_name">Nombre del Paciente</label>
            <input type="text" class="form-control" id="patient_name" name="patient_name" 
                   value="{{ old('patient_name', $appointment->patient_name ?? '') }}" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="patient_contact">Contacto del Paciente</label>
            <input type="text" class="form-control" id="patient_contact" name="patient_contact" 
                   value="{{ old('patient_contact', $appointment->patient_contact ?? '') }}" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="doctor_id">Doctor</label>
            <select class="form-control form-select" id="doctor_id" name="doctor_id" required>
                <option value="">Selecciona un Doctor</option>
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}" 
                            {{ (old('doctor_id', $appointment->doctor_id ?? '') == $doctor->id) ? 'selected' : '' }}>
                        {{ $doctor->name }} - {{ $doctor->specialization }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label class="form-label" for="appointment_time">Hora de la Cita</label>
            <input type="datetime-local" class="form-control" id="appointment_time" name="appointment_time"
                   value="{{ old('appointment_time', isset($appointment) && $appointment->appointment_time ? $appointment->appointment_time->format('Y-m-d\TH:i') : '') }}" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="duration">Duración (minutos)</label>
            <input type="number" class="form-control" id="duration" name="duration" 
                   value="{{ old('duration', $appointment->duration ?? '') }}">
        </div>

        <div class="form-group">
            <label class="form-label" for="status">Estado</label>
            <select class="form-control form-select" id="status" name="status">
                <option value="scheduled" {{ (old('status', $appointment->status ?? '') == 'scheduled') ? 'selected' : '' }}>Programada</option>
                <option value="completed" {{ (old('status', $appointment->status ?? '') == 'completed') ? 'selected' : '' }}>Completada</option>
                <option value="cancelled" {{ (old('status', $appointment->status ?? '') == 'cancelled') ? 'selected' : '' }}>Cancelada</option>
            </select>
        </div>

        <div class="form-group">
            <label class="form-label" for="appointment_notes">Notas de la Cita</label>
            <textarea class="form-control" id="appointment_notes" name="appointment_notes" rows="4">{{ old('appointment_notes', $appointment->appointment_notes ?? '') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">
            {{ isset($appointment) ? 'Actualizar' : 'Crear' }}
        </button>
    </form>
</div>
@endsection