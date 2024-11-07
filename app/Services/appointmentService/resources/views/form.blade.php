@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ isset($appointment) ? 'Editar Cita' : 'Crear Cita' }}</h1>
    <form action="{{ isset($appointment) ? route('appointments.update', $appointment) : route('appointments.store') }}" method="POST">
        @csrf
        @if(isset($appointment))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="patient_name">Nombre del Paciente</label>
            <input type="text" class="form-control" id="patient_name" name="patient_name" value="{{ old('patient_name', $appointment->patient_name ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="patient_contact">Contacto del Paciente</label>
            <input type="text" class="form-control" id="patient_contact" name="patient_contact" value="{{ old('patient_contact', $appointment->patient_contact ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="doctor_id">Doctor</label>
            <select class="form-control" id="doctor_id" name="doctor_id" required>
                <option value="">Selecciona un Doctor</option>
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}" {{ (old('doctor_id', $appointment->doctor_id ?? '') == $doctor->id) ? 'selected' : '' }}>
                        {{ $doctor->name }} - {{ $doctor->specialization }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="appointment_time">Hora de la Cita</label>
            <input type="datetime-local" class="form-control" id="appointment_time" name="appointment_time"
                value="{{ old('appointment_time', isset($appointment) && $appointment->appointment_time ? $appointment->appointment_time->format('Y-m-d\TH:i') : '') }}" required>
        </div>

        <div class="form-group">
            <label for="duration">Duración (minutos)</label>
            <input type="number" class="form-control" id="duration" name="duration" value="{{ old('duration', $appointment->duration ?? '') }}">
        </div>

        <div class="form-group">
            <label for="status">Estado</label>
            <select class="form-control" id="status" name="status">
                <option value="scheduled" {{ (old('status', $appointment->status ?? '') == 'scheduled') ? 'selected' : '' }}>Programada</option>
                <option value="completed" {{ (old('status', $appointment->status ?? '') == 'completed') ? 'selected' : '' }}>Completada</option>
                <option value="cancelled" {{ (old('status', $appointment->status ?? '') == 'cancelled') ? 'selected' : '' }}>Cancelada</option>
            </select>
        </div>

        <div class="form-group">
            <label for="appointment_notes">Notas de la Cita</label>
            <textarea class="form-control" id="appointment_notes" name="appointment_notes">{{ old('appointment_notes', $appointment->appointment_notes ?? '') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">{{ isset($appointment) ? 'Actualizar' : 'Crear' }}</button>
    </form>
</div>
@endsection
