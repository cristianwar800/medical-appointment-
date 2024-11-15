<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function create()
    {
        // Devuelve la vista para registrar un nuevo doctor
        return view('register-doctor'); // Asegúrate de que esta vista existe en resources/views
    }

    /**
     * Almacenar un nuevo doctor en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email',
            'specialization' => 'required|string|max:255',
            'cedula' => 'required|string|max:50|unique:doctors,cedula', // Validación para la cédula única
        ]);

        // Insertar el nuevo doctor en la base de datos
        DB::table('doctors')->insert([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'specialization' => $request->input('specialization'),
            'cedula' => $request->input('cedula'), // Guardar el valor de la cédula
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Redirigir de nuevo al formulario con un mensaje de éxito
        return redirect()->route('doctors.create')->with('success', 'Doctor registrado exitosamente.');
    }
}
