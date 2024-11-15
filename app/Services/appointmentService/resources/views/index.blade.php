@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h1 font-weight-bold text-primary">Citas</h1>
        <a href="{{ route('appointments.create') }}" class="btn btn-primary px-4 py-2 shadow-sm">
            <i class="fas fa-plus-circle mr-2"></i>Agregar Nueva Cita
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="font-weight-bold text-dark">Nombre del Paciente</th>
                            <th class="font-weight-bold text-dark">Contacto</th>
                            <th class="font-weight-bold text-dark">ID del Doctor</th>
                            <th class="font-weight-bold text-dark">Hora de la Cita</th>
                            <th class="font-weight-bold text-dark">Duración</th>
                            <th class="font-weight-bold text-dark">Estado</th>
                            <th class="font-weight-bold text-dark text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $appointment)
                            <tr>
                                <td class="align-middle">{{ $appointment->patient_name }}</td>
                                <td class="align-middle">{{ $appointment->patient_contact }}</td>
                                <td class="align-middle">{{ $appointment->doctor_id }}</td>
                                <td class="align-middle">{{ $appointment->appointment_time }}</td>
                                <td class="align-middle">{{ $appointment->duration }} minutos</td>
                                <td class="align-middle">
                                    <span class="badge badge-{{ $appointment->status === 'Completada' ? 'success' : ($appointment->status === 'Pendiente' ? 'warning' : 'danger') }} px-3 py-2">
                                        {{ $appointment->status }}
                                    </span>
                                </td>
                                <td class="align-middle text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('appointments.show', $appointment) }}" 
                                           class="btn btn-info btn-sm mr-1" 
                                           title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('appointments.edit', $appointment) }}" 
                                           class="btn btn-warning btn-sm mr-1" 
                                           title="Editar cita">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('appointments.destroy', $appointment) }}" 
                                              method="POST" 
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-danger btn-sm" 
                                                    title="Eliminar cita"
                                                    onclick="return confirm('¿Está seguro de que desea eliminar esta cita?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <p class="text-muted mb-0">No hay citas registradas</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    /* Estilos para modo claro */
    .table th {
        font-size: 0.95rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .table td {
        font-size: 0.9rem;
        color: #444;
    }
    .badge {
        font-weight: 500;
        font-size: 0.85rem;
    }
    .btn-group .btn {
        padding: 0.375rem 0.75rem;
    }
    .card {
        border-radius: 8px;
    }
    
    /* Estilos para modo oscuro */
    body.dark-mode .table th {
        color: #ffffff !important;
    }
    body.dark-mode .table td {
        color: #e4e4e4;
    }
    body.dark-mode .card {
        background-color: #2d2d2d;
        border: 1px solid #404040;
    }
    body.dark-mode .text-dark {
        color: #ffffff !important;
    }
    body.dark-mode .text-muted {
        color: #adb5bd !important;
    }
    body.dark-mode .table {
        color: #e4e4e4;
    }
    body.dark-mode .table-hover tbody tr:hover {
        background-color: rgba(255,255,255,0.075);
    }
</style>

<!-- Asegúrate de incluir Font Awesome en el layout -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection