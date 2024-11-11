<?php

namespace App\Services\Citas\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_name',
        'patient_contact',
        'doctor_id',
        'appointment_time',
        'duration',
        'status',
        'appointment_notes'
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
