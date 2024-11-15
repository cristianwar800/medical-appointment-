@extends('layouts.app')

@section('content')
<div class="appointment-container">
    <div class="appointment-card">
        <div class="card-header">
            <h1 class="card-title">Detalles de la Cita</h1>
            <span class="appointment-id" id="appointmentId"></span>
        </div>

        <div class="info-grid">
            <!-- Información del Paciente -->
            <div class="info-section">
                <h2 class="section-title">Información del Paciente</h2>
                <div class="info-item">
                    <span class="info-label">Nombre:</span>
                    <span id="patientName">{{ $appointment->patient_name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Contacto:</span>
                    <span id="patientContact">{{ $appointment->patient_contact }}</span>
                </div>
            </div>

            <!-- Doctor -->
            <div class="info-section">
                <h2 class="section-title">Doctor Asignado</h2>
                <div class="info-item">
                    <span class="info-label">Doctor:</span>
                    <span id="doctorName">{{ optional($appointment->doctor)->name }}</span>
                </div>
            </div>

            <!-- Fecha y Duración -->
            <div class="info-section">
                <h2 class="section-title">Fecha y Duración</h2>
                <div class="info-item">
                    <span class="info-label">Fecha:</span>
                    <span id="appointmentDate">
                        @if($appointment->appointment_time instanceof \Carbon\Carbon)
                            {{ $appointment->appointment_time->format('d/m/Y H:i') }}
                        @else
                            {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('d/m/Y H:i') }}
                        @endif
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Duración:</span>
                    <span id="appointmentDuration">{{ $appointment->duration }} minutos</span>
                </div>
            </div>

            <!-- Estado -->
            <div class="info-section">
                <h2 class="section-title">Estado de la Cita</h2>
                <span id="appointmentStatus" class="status-badge"></span>
            </div>

            <!-- Notas -->
            @if($appointment->appointment_notes)
            <div class="info-section" id="notesSection">
                <h2 class="section-title">Notas</h2>
                <div class="info-item" id="appointmentNotes"></div>
            </div>
            @endif
        </div>

        <div class="actions-bar">
            <button class="btn btn-back" onclick="goBack()">Volver</button>
            <button class="btn btn-edit" onclick="editAppointment()">Editar</button>
            <button id="cancelButton" class="btn btn-cancel" onclick="cancelAppointment()">Cancelar</button>
        </div>
    </div>
</div>

<style>
    .appointment-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 0 1rem;
    }

    .appointment-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .card-header {
        background: linear-gradient(135deg, #3182ce, #2c5282);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 8px 8px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0;
    }

    .appointment-id {
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
        padding: 1.5rem;
    }

    .info-section {
        background: #f8fafc;
        padding: 1rem;
        border-radius: 6px;
    }

    .section-title {
        color: #2d3748;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-item {
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }

    .info-label {
        color: #718096;
        font-weight: 500;
        margin-right: 0.5rem;
    }

    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .status-scheduled { background: #ebf8ff; color: #2b6cb0; }
    .status-completed { background: #f0fff4; color: #2f855a; }
    .status-cancelled { background: #fff5f5; color: #c53030; }

    .actions-bar {
        padding: 1rem 1.5rem;
        background: #f8fafc;
        border-top: 1px solid #edf2f7;
        border-radius: 0 0 8px 8px;
        display: flex;
        justify-content: flex-end;
        gap: 0.5rem;
    }

    .btn {
        padding: 0.4rem 0.8rem;
        border-radius: 4px;
        font-size: 0.85rem;
        font-weight: 500;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-back {
        background: #718096;
        color: white;
    }

    .btn-edit {
        background: #4299e1;
        color: white;
    }

    .btn-cancel {
        background: #f56565;
        color: white;
    }

    .btn:hover {
        transform: translateY(-1px);
        opacity: 0.95;
    }

    /* Dark mode */
    body.dark-mode {
        background-color: #1a1a1a;
    }

    body.dark-mode .appointment-card {
        background: #2d3748;
    }

    body.dark-mode .info-section {
        background: #4a5568;
    }

    body.dark-mode .section-title {
        color: #e2e8f0;
    }

    body.dark-mode .info-label {
        color: #a0aec0;
    }

    body.dark-mode .info-item {
        color: #e2e8f0;
    }

    body.dark-mode .actions-bar {
        background: #4a5568;
        border-top-color: #718096;
    }

    body.dark-mode .status-scheduled {
        background: #2c5282;
        color: #bee3f8;
    }

    body.dark-mode .status-completed {
        background: #276749;
        color: #c6f6d5;
    }

    body.dark-mode .status-cancelled {
        background: #9b2c2c;
        color: #fed7d7;
    }
</style>

<script>
    // Simulación de datos de la cita usando las variables de Laravel
    const appointment = {
        id: {{ $appointment->id }},
        patient_name: "{{ $appointment->patient_name }}",
        patient_contact: "{{ $appointment->patient_contact }}",
        doctor: { name: "{{ optional($appointment->doctor)->name }}" },
        appointment_time: "{{ $appointment->appointment_time }}",
        duration: {{ $appointment->duration }},
        status: "{{ $appointment->status }}",
        appointment_notes: "{{ $appointment->appointment_notes }}"
    };

    // Función para formatear la fecha
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleString('es-ES', { 
            year: 'numeric', 
            month: '2-digit', 
            day: '2-digit',
            hour: '2-digit', 
            minute: '2-digit'
        });
    }

    // Función para establecer el contenido de los elementos
    function setElementContent(id, content) {
        document.getElementById(id).textContent = content;
    }

    // Cargar datos de la cita
    window.onload = function() {
        setElementContent('appointmentId', `#${appointment.id}`);
        setElementContent('patientName', appointment.patient_name);
        setElementContent('patientContact', appointment.patient_contact);
        setElementContent('doctorName', appointment.doctor.name);
        setElementContent('appointmentDate', formatDate(appointment.appointment_time));
        setElementContent('appointmentDuration', `${appointment.duration} minutos`);

        const statusElement = document.getElementById('appointmentStatus');
        statusElement.textContent = appointment.status === 'scheduled' ? 'Programada' :
                                  appointment.status === 'completed' ? 'Completada' : 'Cancelada';
        statusElement.className = `status-badge status-${appointment.status}`;

        if (appointment.appointment_notes) {
            document.getElementById('notesSection').style.display = 'block';
            setElementContent('appointmentNotes', appointment.appointment_notes);
        }

        if (appointment.status === 'cancelled') {
            document.getElementById('cancelButton').style.display = 'none';
        }
    };

    // Funciones para los botones
    function goBack() {
        window.location.href = "{{ route('appointments.index') }}";
    }

    function editAppointment() {
        window.location.href = "{{ route('appointments.edit', $appointment) }}";
    }

    function cancelAppointment() {
        if (confirm('¿Está seguro de que desea cancelar esta cita?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = "{{ route('appointments.cancel', $appointment) }}";
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = "{{ csrf_token() }}";
            
            const method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'PATCH';

            form.appendChild(csrfToken);
            form.appendChild(method);
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>
@endsection