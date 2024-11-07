<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = ['patient_name', 'patient_contact', 'doctor_id', 'appointment_time', 'duration', 'status', 'appointment_notes'];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
