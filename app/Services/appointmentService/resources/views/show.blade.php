@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalles de la Cita</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $appointment->patient_name }}</h5>
            <h6 class="card-subtitle mb-2 text-muted">{{ $appointment->appointment_time }}</h6>
            <p class="card-text">Contacto: {{ $appointment->patient_contact }}</p>
            <p class="card-text">ID del Doctor: {{ $appointment->doctor_id }}</p>
            <p class="card-text">Duración: {{ $appointment->duration }} minutos</p>
            <p class="card-text">Estado: {{ $appointment->status }}</p>
            <p class="card-text">Notas: {{ $appointment->appointment_notes }}</p>
            <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-warning">Editar Cita</a>
        </div>
    </div>
</div>
@endsection
