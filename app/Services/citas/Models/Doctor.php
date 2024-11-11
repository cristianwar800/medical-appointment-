<?php

namespace App\Services\Citas\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'specialization'
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
