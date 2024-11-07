
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Appointment Details</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $appointment->patient_name }}</h5>
            <h6 class="card-subtitle mb-2 text-muted">{{ $appointment->appointment_time }}</h6>
            <p class="card-text">Contact: {{ $appointment->patient_contact }}</p>
            <p class="card-text">Doctor ID: {{ $appointment->doctor_id }}</p>
            <p class="card-text">Duration: {{ $appointment->duration }} minutes</p>
            <p class="card-text">Status: {{ $appointment->status }}</p>
            <p class="card-text">Notes: {{ $appointment->appointment_notes }}</p>
            <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-warning">Edit Appointment</a>
        </div>
    </div>
</div>
@endsection