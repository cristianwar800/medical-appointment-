<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    protected $responses = [
        'doctor' => [
            'saludos' => [
                'patrones' => [
                    'hola', 'buenos dias', 'buenas tardes', 'buenas noches',
                    'saludos', 'que tal', 'hey'
                ],
                'respuestas' => [
                    '¡Bienvenido Doctor! ¿En qué puedo ayudarle hoy? 👨‍⚕️',
                    'Hola Doctor, estoy aquí para asistirle. ¿Qué necesita? 🏥',
                    '¡Buenos días Doctor! ¿Cómo puedo ayudarle con su consulta hoy? 👋'
                ]
            ],
            // ... otras categorías de doctor ...
        ],
        'receptionist' => [
            'saludos' => [
                'patrones' => [
                    'hola', 'buenos dias', 'buenas tardes', 'buenas noches',
                    'saludos', 'que tal', 'hey'
                ],
                'respuestas' => [
                    '¡Bienvenido/a! ¿En qué puedo ayudarle con la gestión de pacientes? 👋',
                    'Hola, estoy aquí para ayudarle. ¿Qué necesita? 🏥',
                    '¡Buenos días! ¿Cómo puedo asistirle hoy? 💼'
                ]
            ],
            // ... otras categorías de recepcionista ...
        ]
    ];

    public function index()
    {
        return view('chat.chat');
    }

    public function sendMessage(Request $request)
    {
        \Log::info('Mensaje recibido:', $request->all()); // Debugging

        try {
            // Validación básica
            if (empty($request->message) || empty($request->user_type)) {
                throw new \Exception('Faltan datos requeridos');
            }

            $message = strtolower(trim($request->message));
            $userType = $request->user_type;

            // Obtener respuesta
            $botResponse = $this->getSimpleResponse($message, $userType);

            \Log::info('Respuesta generada:', ['response' => $botResponse]); // Debugging

            return response()->json([
                'status' => 'success',
                'message' => $botResponse
            ]);

        } catch (\Exception $e) {
            \Log::error('Error en ChatbotController:', ['error' => $e->getMessage()]); // Debugging
            
            return response()->json([
                'status' => 'error',
                'message' => 'Lo siento, ha ocurrido un error. Por favor, intenta de nuevo.'
            ], 500);
        }
    }

    protected function getSimpleResponse($message, $userType)
    {
        // Primero intentamos encontrar un saludo
        $message = strtolower($message);
        
        // Buscar en patrones de saludo
        foreach ($this->responses[$userType]['saludos']['patrones'] as $patron) {
            if (str_contains($message, $patron)) {
                $respuestas = $this->responses[$userType]['saludos']['respuestas'];
                return $respuestas[array_rand($respuestas)];
            }
        }
        
        // Si no es un saludo, dar una respuesta general
        $respuestasGenerales = [
            'doctor' => [
                '¿En qué puedo ayudarle con su práctica médica? 👨‍⚕️',
                'Estoy aquí para asistirle. ¿Qué necesita consultar? 🏥',
                'Dígame qué información necesita y con gusto le ayudo. 📋'
            ],
            'receptionist' => [
                '¿En qué puedo ayudarle con la gestión de pacientes? 👥',
                'Estoy aquí para ayudar. ¿Qué necesita gestionar? 📅',
                '¿Cómo puedo asistirle con el sistema de citas? 💼'
            ]
        ];

        return $respuestasGenerales[$userType][array_rand($respuestasGenerales[$userType])];
    }
}