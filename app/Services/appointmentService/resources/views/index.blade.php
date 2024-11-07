@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Citas</h1>
    <a href="{{ route('appointments.create') }}" class="btn btn-primary">Agregar Nueva Cita</a>
    <table class="table">
        <thead>
            <tr>
                <th>Nombre del Paciente</th>
                <th>Contacto</th>
                <th>ID del Doctor</th>
                <th>Hora de la Cita</th>
                <th>Duración</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $appointment)
            <tr>
                <td>{{ $appointment->patient_name }}</td>
                <td>{{ $appointment->patient_contact }}</td>
                <td>{{ $appointment->doctor_id }}</td>
                <td>{{ $appointment->appointment_time }}</td>
                <td>{{ $appointment->duration }} minutos</td>
                <td>{{ $appointment->status }}</td>
                <td>
                    <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-info">Ver</a>
                    <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('appointments.destroy', $appointment) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
