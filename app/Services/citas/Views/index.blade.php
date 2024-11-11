
<div class="container">
    <h1>Appointments</h1>
    <a href="{{ route('appointments.create') }}" class="btn btn-primary">Add New Appointment</a>
    <table class="table">
        <thead>
            <tr>
                <th>Patient Name</th>
                <th>Contact</th>
                <th>Doctor ID</th>
                <th>Appointment Time</th>
                <th>Duration</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $appointment)
            <tr>
                <td>{{ $appointment->patient_name }}</td>
                <td>{{ $appointment->patient_contact }}</td>
                <td>{{ $appointment->doctor_id }}</td>
                <td>{{ $appointment->appointment_time }}</td>
                <td>{{ $appointment->duration }} minutes</td>
                <td>{{ $appointment->status }}</td>
                <td>
                    <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-info">View</a>
                    <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('appointments.destroy', $appointment) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

