<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ChatbotApiController extends Controller
{
    protected $responses = [
        'doctor' => [
            'saludos' => [
                '¡Bienvenido Doctor! ¿En qué puedo ayudarle hoy? 👨‍⚕️',
                'Hola Doctor, estoy aquí para asistirle. ¿Qué necesita? 🏥',
                '¡Buenos días Doctor! ¿Cómo puedo ayudarle con su consulta hoy? 👋'
            ],
            'agenda' => [
                'Consultando su agenda, un momento por favor... 📅',
                'Verificando sus citas programadas... ⌛',
                'Revisando el calendario de consultas... 🗓️'
            ],
            'despedida' => [
                'Hasta luego Doctor, ¡que tenga un excelente día! 👋',
                '¡Ha sido un placer ayudarle! Hasta pronto 🌟',
                'Que tenga un excelente resto del día. ¡Hasta luego! 👨‍⚕️'
            ]
        ],
        'receptionist' => [
            'saludos' => [
                '¡Bienvenido/a! ¿En qué puedo ayudarle con la gestión de pacientes? 👋',
                'Hola, estoy aquí para ayudarle. ¿Qué necesita? 🏥',
                '¡Buenos días! ¿Cómo puedo asistirle hoy? 💼'
            ],
            'agenda' => [
                'Consultando el sistema de citas... 📅',
                'Verificando la agenda... ⌛',
                'Accediendo a los registros de citas... 🗓️'
            ],
            'despedida' => [
                '¡Hasta luego! ¡Que tenga un excelente día! 👋',
                '¡Nos vemos pronto! 🌟',
                '¡Cuídese! 💫'
            ]
        ]
    ];

    /**
     * Endpoint de prueba
     * GET /api/chatbot/test
     */
    public function test()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'API del Chatbot funcionando correctamente',
            'timestamp' => Carbon::now()->toDateTimeString()
        ]);
    }

    /**
     * Procesa un mensaje del usuario
     * POST /api/chatbot/message
     * @param Request $request
     */
    public function processMessage(Request $request)
    {
        try {
            $request->validate([
                'message' => 'required|string',
                'user_type' => 'required|in:doctor,receptionist',
                'session_id' => 'required|string'
            ]);

            $message = strtolower(trim($request->message));
            $userType = $request->user_type;
            $sessionId = $request->session_id;

            // Almacenar mensaje del usuario
            $this->storeMessage($sessionId, $message, 'user', $userType);

            // Determinar respuesta basada en el mensaje
            $response = $this->processIntent($message, $userType);

            // Almacenar respuesta del bot
            $this->storeMessage($sessionId, $response, 'bot', $userType);

            return response()->json([
                'status' => 'success',
                'message' => $response,
                'session_id' => $sessionId
            ]);

        } catch (\Exception $e) {
            Log::error('Error en processMessage:', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 'error',
                'message' => 'Error procesando mensaje: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene las citas pendientes
     * GET /api/chatbot/appointments/pending
     */
    public function getPendingAppointments()
    {
        try {
            $appointments = DB::table('appointments')
                ->join('doctors', 'appointments.doctor_id', '=', 'doctors.id')
                ->where('status', 'scheduled')
                ->orderBy('appointment_time')
                ->get();

            if ($appointments->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'No hay citas pendientes programadas.',
                    'data' => []
                ]);
            }

            $formattedAppointments = $appointments->map(function ($appointment) {
                return [
                    'fecha' => Carbon::parse($appointment->appointment_time)->format('d/m/Y'),
                    'hora' => Carbon::parse($appointment->appointment_time)->format('H:i'),
                    'paciente' => $appointment->patient_name,
                    'doctor' => $appointment->doctor_name,
                    'contacto' => $appointment->patient_contact,
                    'estado' => $this->getStatusEmoji($appointment->status)
                ];
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Citas pendientes recuperadas exitosamente',
                'data' => $formattedAppointments
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al obtener citas pendientes: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene estadísticas del chatbot
     * GET /api/chatbot/stats
     */
    public function getStats()
    {
        try {
            $stats = [
                'mensajes_totales' => ChatMessage::count(),
                'mensajes_bot' => ChatMessage::where('type', 'bot')->count(),
                'mensajes_usuario' => ChatMessage::where('type', 'user')->count(),
                'sesiones_totales' => ChatMessage::distinct('session_id')->count(),
                'ultimo_mensaje' => ChatMessage::latest()->first()?->message,
                'mensajes_hoy' => ChatMessage::whereDate('created_at', Carbon::today())->count()
            ];

            return response()->json([
                'status' => 'success',
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al obtener estadísticas: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene el historial de chat
     * GET /api/chatbot/history/{sessionId?}
     */
    public function getChatHistory($sessionId = null)
    {
        try {
            $query = ChatMessage::query();
            
            if ($sessionId) {
                $query->where('session_id', $sessionId);
            }

            $messages = $query->orderBy('created_at', 'desc')
                            ->limit(10)
                            ->get()
                            ->map(function ($message) {
                                return [
                                    'tipo' => $message->type,
                                    'mensaje' => $message->message,
                                    'tipo_usuario' => $message->user_type,
                                    'fecha' => $message->created_at->format('d/m/Y H:i:s')
                                ];
                            });

            return response()->json([
                'status' => 'success',
                'data' => $messages
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al obtener historial: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Procesa la intención del mensaje
     */
    protected function processIntent($message, $userType)
    {
        if ($this->isGreeting($message)) {
            return $this->getRandomResponse($userType, 'saludos');
        }

        if ($this->isFarewell($message)) {
            return $this->getRandomResponse($userType, 'despedida');
        }

        if ($this->isAgendaQuery($message)) {
            return $this->getAgendaResponse();
        }

        if (str_contains($message, 'citas pendientes')) {
            return $this->getPendingAppointmentsMessage();
        }

        // Respuesta por defecto
        return "Estoy aquí para ayudar. ¿Podría ser más específico? 🤔";
    }

    protected function isGreeting($message)
    {
        $saludos = ['hola', 'buenos dias', 'buenas tardes', 'buenas noches', 'saludos', 'que tal', 'hey'];
        foreach ($saludos as $saludo) {
            if (str_contains($message, $saludo)) {
                return true;
            }
        }
        return false;
    }

    protected function isFarewell($message)
    {
        $despedidas = ['adios', 'hasta luego', 'nos vemos', 'chao', 'gracias', 'bye'];
        foreach ($despedidas as $despedida) {
            if (str_contains($message, $despedida)) {
                return true;
            }
        }
        return false;
    }

    protected function isAgendaQuery($message)
    {
        $keywords = ['agenda', 'citas', 'horario', 'calendario', 'programación'];
        foreach ($keywords as $keyword) {
            if (str_contains($message, $keyword)) {
                return true;
            }
        }
        return false;
    }

    protected function getRandomResponse($userType, $category)
    {
        $responses = $this->responses[$userType][$category];
        return $responses[array_rand($responses)];
    }

    protected function getStatusEmoji($status)
    {
        return match ($status) {
            'scheduled' => '⏳ Programada',
            'completed' => '✅ Completada',
            'cancelled' => '❌ Cancelada',
            'pending' => '📋 Pendiente',
            'in_progress' => '🔄 En Proceso',
            default => '❓ Desconocido'
        };
    }

    /**
     * Almacena un mensaje en la base de datos
     */
    protected function storeMessage($sessionId, $message, $type, $userType)
    {
        ChatMessage::create([
            'session_id' => $sessionId,
            'message' => $message,
            'type' => $type,
            'user_type' => $userType
        ]);
    }

    /**
     * Obtiene un mensaje formateado de citas pendientes
     */
    protected function getPendingAppointmentsMessage()
    {
        $appointments = DB::table('appointments')
            ->join('doctors', 'appointments.doctor_id', '=', 'doctors.id')
            ->where('status', 'scheduled')
            ->orderBy('appointment_time')
            ->get();

        if ($appointments->isEmpty()) {
            return "No hay citas pendientes programadas. 📋";
        }

        $response = "📋 Citas Pendientes:\n\n";
        foreach ($appointments as $appointment) {
            $fecha = Carbon::parse($appointment->appointment_time)->format('d/m/Y');
            $hora = Carbon::parse($appointment->appointment_time)->format('H:i');
            
            $response .= "📅 Fecha: {$fecha}\n";
            $response .= "⏰ Hora: {$hora}\n";
            $response .= "👤 Paciente: {$appointment->patient_name}\n";
            $response .= "👨‍⚕️ Doctor: {$appointment->doctor_name}\n";
            $response .= "📱 Contacto: {$appointment->patient_contact}\n";
            $response .= "──────────────\n";
        }

        return $response;
    }
}