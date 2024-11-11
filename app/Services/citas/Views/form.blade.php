<div class="container">
    <h1>{{ isset($appointment) ? 'Edit Appointment' : 'Create Appointment' }}</h1>
    <form action="{{ isset($appointment) ? route('appointments.update', $appointment) : route('appointments.store') }}" method="POST">
        @csrf
        @if(isset($appointment))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="patient_name">Patient Name</label>
            <input type="text" class="form-control" id="patient_name" name="patient_name" value="{{ old('patient_name', $appointment->patient_name ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="patient_contact">Patient Contact</label>
            <input type="text" class="form-control" id="patient_contact" name="patient_contact" value="{{ old('patient_contact', $appointment->patient_contact ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="doctor_id">Doctor</label>
            <select class="form-control" id="doctor_id" name="doctor_id" required>
                <option value="">Select Doctor</option>
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}" {{ (old('doctor_id', $appointment->doctor_id ?? '') == $doctor->id) ? 'selected' : '' }}>
                        {{ $doctor->name }} - {{ $doctor->specialization }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="appointment_time">Appointment Time</label>
            <input type="datetime-local" class="form-control" id="appointment_time" name="appointment_time"
                   value="{{ old('appointment_time', isset($appointment) && $appointment->appointment_time instanceof \Carbon\Carbon ? $appointment->appointment_time->format('Y-m-d\TH:i') : '') }}" required>
        </div>

        <div class="form-group">
            <label for="duration">Duration (minutes)</label>
            <input type="number" class="form-control" id="duration" name="duration" value="{{ old('duration', $appointment->duration ?? '') }}">
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status">
                <option value="scheduled" {{ (old('status', $appointment->status ?? '') == 'scheduled') ? 'selected' : '' }}>Scheduled</option>
                <option value="completed" {{ (old('status', $appointment->status ?? '') == 'completed') ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ (old('status', $appointment->status ?? '') == 'cancelled') ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>

        <div class="form-group">
            <label for="appointment_notes">Appointment Notes</label>
            <textarea class="form-control" id="appointment_notes" name="appointment_notes">{{ old('appointment_notes', $appointment->appointment_notes ?? '') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">{{ isset($appointment) ? 'Update' : 'Create' }}</button>
    </form>
</div>

