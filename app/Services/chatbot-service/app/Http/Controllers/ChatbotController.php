<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ChatbotController extends Controller
{
    protected $responses = [
        'doctor' => [
            'saludos' => [
                'patrones' => [
                    'hola', 'buenos dias', 'buenas tardes', 'buenas noches',
                    'saludos', 'que tal', 'hey', 'hi', 'hello', 'alo',
                    'buen dia', 'como estas', 'como va', 'que hay'
                ],
                'respuestas' => [
                    '¡Bienvenido Doctor! ¿En qué puedo ayudarle hoy? 👨‍⚕️',
                    'Hola Doctor, estoy aquí para asistirle. ¿Qué necesita? 🏥',
                    '¡Buenos días Doctor! ¿Cómo puedo ayudarle con su consulta hoy? 👋',
                    '¡Saludos Doctor! ¿En qué le puedo ser útil? 🩺',
                    'Bienvenido nuevamente, ¿qué necesita consultar hoy? 📋',
                    '¡Hola! Me alegro de verle. ¿Necesita revisar algo específico? 🌟',
                    'A sus órdenes, Doctor. ¿Cómo puedo ayudarle? 💼',
                    '¡Buen día! Estoy listo para asistirle en lo que necesite 🤝'
                ]
            ],
            'agenda' => [
                'patrones' => [
                    'mostrar agenda', 'ver agenda', 'consultar agenda',
                    'ver citas', 'mostrar citas', 'que citas tengo',
                    'pacientes para hoy', 'consultas pendientes',
                    'horario de hoy', 'proximas citas', 'siguientes pacientes',
                    'agenda del dia', 'citas pendientes', 'revision de agenda',
                    'calendario', 'programacion', 'horarios', 'ver pacientes',
                    'consultas de hoy', 'quien sigue', 'siguiente paciente'
                ],
                'respuestas' => [
                    'Consultando su agenda, un momento por favor... 📅',
                    'Verificando sus citas programadas... ⌛',
                    'Revisando el calendario de consultas... 🗓️',
                    'Accediendo a su agenda del día... 📊',
                    'Consultando la programación de pacientes... 👥',
                    'Un momento, recuperando su horario de consultas... ⏰'
                ]
            ],
            'consulta_estado' => [
                'patrones' => [
                    'estado de cita', 'estado cita', 'consultar estado',
                    'como va la cita', 'status de cita', 'verificar cita',
                    'buscar cita', 'consultar cita', 'información de cita',
                    'detalles de cita', 'revisar cita'
                ],
                'respuestas' => [
                    'Por favor, indique el nombre del paciente o la fecha de la cita que desea consultar 🔍',
                    'Para consultar el estado, necesito: \n- Nombre del paciente o\n- Fecha de la cita 📋',
                    '¿Podría proporcionarme el nombre del paciente o la fecha para verificar su cita? 🤔'
                ]
            ],
            'citas_pendientes' => [
                'patrones' => [
                    'citas pendientes', 'pendientes', 'sin atender',
                    'próximas citas', 'siguientes citas', 'que sigue',
                    'por atender', 'en espera', 'programadas pendientes'
                ],
                'respuestas' => [
                    'Consultando sus citas pendientes... ⏳',
                    'Verificando las próximas citas programadas... 📋',
                    'Buscando citas pendientes de atención... 🔍'
                ]
            ],
            'citas_hoy' => [
                'patrones' => [
                    'citas hoy', 'agenda hoy', 'para hoy',
                    'pacientes hoy', 'consultas hoy', 'el dia de hoy',
                    'día actual', 'agenda actual'
                ],
                'respuestas' => [
                    'Consultando las citas de hoy... 📅',
                    'Verificando su agenda del día... ⏰',
                    'Buscando los pacientes programados para hoy... 👥'
                ]
            ],
            'citas_fecha' => [
                'patrones' => [
                    'citas del', 'citas para el', 'agenda del',
                    'consultas del', 'pacientes del', 'consultar fecha',
                    'buscar fecha', 'citas en', 'horario del'
                ],
                'respuestas' => [
                    'Por favor, indique la fecha que desea consultar 📅',
                    '¿Para qué fecha desea ver las citas? 🗓️',
                    'Indíqueme la fecha para verificar la agenda ⌛'
                ]
            ],
            'estadisticas' => [
                'patrones' => [
                    'estadísticas', 'resumen', 'totales', 'números',
                    'cantidades', 'conteo', 'métricas', 'datos generales',
                    'información general'
                ],
                'respuestas' => [
                    'Consultando estadísticas de citas... 📊',
                    'Generando resumen de agenda... 📈',
                    'Preparando informe de citas... 📑'
                ]
            ],
            'buscar_paciente' => [
                'patrones' => [
                    'buscar paciente', 'encontrar paciente', 'información paciente',
                    'datos paciente', 'historial paciente', 'consultar paciente',
                    'expediente paciente', 'ficha paciente'
                ],
                'respuestas' => [
                    'Por favor, indique el nombre del paciente que desea buscar 🔍',
                    '¿Qué paciente desea consultar? 👤',
                    'Necesito el nombre del paciente para buscarlo 📋'
                ]
            ],
            'despedida' => [
                'patrones' => [
                    'adios', 'hasta luego', 'nos vemos', 'bye', 'chao',
                    'hasta pronto', 'me voy', 'gracias', 'hasta mañana',
                    'me retiro', 'eso es todo', 'es todo', 'terminamos',
                    'finalizar', 'terminar', 'cerrar', 'desconectar'
                ],
                'respuestas' => [
                    'Hasta luego Doctor, que tenga un excelente día! 👋',
                    'Ha sido un placer ayudarle. ¡Hasta pronto! 🌟',
                    'Que tenga un excelente resto del día. ¡Hasta luego! 👨‍⚕️',
                    'Gracias por su tiempo. Estoy aquí cuando me necesite. 🤝',
                    'Hasta la próxima. ¡Que tenga un gran día! ✨',
                    'Me alegra haber podido ayudar. ¡Hasta pronto! 💫'
                ]
            ],
            'ayuda' => [
                'patrones' => [
                    'ayuda', 'help', 'que puedes hacer', 'comandos',
                    'opciones', 'funciones', 'como funciona', 'instrucciones',
                    'que haces', 'menu', 'guia', 'tutorial', 'asistencia'
                ],
                'respuestas' => [
                    'Puedo ayudarle con lo siguiente:\n' .
                    '📅 Consultar su agenda y citas\n' .
                    '👥 Ver información de pacientes\n' .
                    '📊 Revisar horarios\n' .
                    '¿Qué desea hacer? 🤔',
    
                    'Estoy aquí para ayudarle con:\n' .
                    '• Gestión de agenda y citas 📅\n' .
                    '• Consulta de pacientes 👥\n' .
                    '• Horarios y programación ⏰\n' .
                    '¿Qué necesita consultar? 💫',
    
                    'Mis principales funciones son:\n' .
                    '1. Mostrar su agenda del día 📅\n' .
                    '2. Consultar citas pendientes ⏳\n' .
                    '3. Ver información de pacientes 👥\n' .
                    '¿En qué puedo ayudarle? 🌟'
                ]
            ],
            'confirmacion' => [
                'patrones' => [
                    'si', 'correcto', 'exacto', 'asi es', 'efectivamente',
                    'ok', 'dale', 'procede', 'adelante', 'por favor',
                    'confirmo', 'confirmado', 'perfecto', 'excelente'
                ],
                'respuestas' => [
                    '¡Perfecto! Procedo con su solicitud... ✨',
                    'Excelente, continuamos entonces... 🚀',
                    'Muy bien, procesando su petición... ⚡',
                    'Entendido, trabajando en ello... 🎯',
                    'De acuerdo, en seguida le ayudo... 🌟'
                ]
            ],
            'negacion' => [
                'patrones' => [
                    'no', 'negativo', 'aun no', 'todavia no', 'para nada',
                    'no gracias', 'nop', 'nel', 'mejor no', 'en otro momento'
                ],
                'respuestas' => [
                    'De acuerdo, ¿hay algo más en que pueda ayudarle? 🤔',
                    'Entiendo, ¿necesita ayuda con algo más? 💭',
                    '¿Puedo asistirle en alguna otra cosa? 📋',
                    'Muy bien, estoy aquí si necesita algo más 👍',
                    'Como guste. ¿Hay algo más que pueda hacer por usted? 🌟'
                ]
            ],
            'estado' => [
                'patrones' => [
                    'como vas', 'que tal va', 'como va todo', 'como esta todo',
                    'que hay de nuevo', 'novedades', 'que hay', 'que cuentas'
                ],
                'respuestas' => [
                    'Todo en orden, Doctor. ¿En qué puedo ayudarle? 👨‍⚕️',
                    'Funcionando perfectamente. ¿Necesita consultar algo? 🌟',
                    'Todo marcha bien. ¿Qué necesita revisar? 📊',
                    'Sistema operando normalmente. ¿En qué le puedo asistir? 💫',
                    'Todo bajo control. ¿Necesita ayuda con algo? 🤖'
                ]
            ]
        ],
        'receptionist' => [
            'saludos' => [
                'patrones' => [
                    'hola', 'buenos dias', 'buenas tardes', 'buenas noches',
                    'saludos', 'que tal', 'hey', 'hi', 'hello', 'buen dia'
                ],
                'respuestas' => [
                    '¡Bienvenido/a! ¿En qué puedo ayudarle con la gestión de pacientes? 👋',
                    'Hola, estoy aquí para ayudarle. ¿Qué necesita? 🏥',
                    '¡Buenos días! ¿Cómo puedo asistirle hoy? 💼',
                    'Bienvenido/a al sistema. ¿En qué puedo ayudarle? 🌟',
                    '¡Hola! ¿Qué gestión necesita realizar hoy? 📋',
                    'A sus órdenes. ¿Cómo puedo ayudarle con la agenda? 📅'
                ]
            ],
            'gestion_citas' => [
                'patrones' => [
                    'agendar cita', 'nueva cita', 'programar cita',
                    'reservar horario', 'crear cita', 'añadir cita',
                    'registro de cita', 'agendar paciente', 'programar consulta'
                ],
                'respuestas' => [
                    'Para agendar una nueva cita necesito los siguientes datos:\n' .
                    '👤 Nombre del paciente\n' .
                    '📅 Fecha deseada\n' .
                    '👨‍⚕️ Doctor preferido\n' .
                    '¿Tiene esta información disponible?',
    
                    'Para programar una cita, por favor indique:\n' .
                    '• Datos del paciente\n' .
                    '• Fecha preferida\n' .
                    '• Especialidad requerida\n' .
                    '¿Me puede proporcionar estos datos?',
    
                    'Ayúdeme con la siguiente información para la cita:\n' .
                    '1. Nombre completo del paciente\n' .
                    '2. Fecha y hora deseada\n' .
                    '3. Especialista a consultar\n' .
                    '¿Tiene estos datos a la mano?'
                ]
            ]
        ]
    ];


    protected function getAppointmentStatus($patientName = null, $date = null)
    {
        try {
            $query = DB::table('appointments')
                ->join('doctors', 'appointments.doctor_id', '=', 'doctors.id')
                ->select(
                    'appointments.*',
                    'doctors.name as doctor_name'
                );
    
            if ($patientName) {
                $query->where('patient_name', 'LIKE', "%{$patientName}%");
            }
    
            if ($date) {
                $query->whereDate('appointment_time', Carbon::parse($date));
            }
    
            $appointments = $query->get();
    
            if ($appointments->isEmpty()) {
                return "No encontré citas con esos datos. ¿Desea intentar con otros criterios? 🤔";
            }
    
            $response = "📋 Información de citas encontradas:\n\n";
            foreach ($appointments as $appointment) {
                $fecha = Carbon::parse($appointment->appointment_time)->format('d/m/Y');
                $hora = Carbon::parse($appointment->appointment_time)->format('H:i');
                
                $response .= "📅 Fecha: {$fecha}\n";
                $response .= "⏰ Hora: {$hora}\n";
                $response .= "👤 Paciente: {$appointment->patient_name}\n";
                $response .= "👨‍⚕️ Doctor: {$appointment->doctor_name}\n";
                $response .= "📱 Contacto: {$appointment->patient_contact}\n";
                $response .= "🔄 Estado: " . $this->getStatusEmoji($appointment->status) . "\n";
                
                if ($appointment->appointment_notes) {
                    $response .= "📝 Notas: {$appointment->appointment_notes}\n";
                }
                
                $response .= "──────────────\n";
            }
    
            return $response;
        } catch (\Exception $e) {
            Log::error('Error consultando estado de cita:', ['error' => $e->getMessage()]);
            return "Lo siento, hubo un problema al consultar el estado. ¿Podría intentarlo nuevamente? 😕";
        }
    }
    protected function getAppointmentStats()
    {
        try {
            $today = Carbon::today();
            $stats = [
                'today' => DB::table('appointments')->whereDate('appointment_time', $today)->count(),
                'pending' => DB::table('appointments')->where('status', 'scheduled')->count(),
                'completed' => DB::table('appointments')->where('status', 'completed')->count(),
                'cancelled' => DB::table('appointments')->where('status', 'cancelled')->count(),
                'total' => DB::table('appointments')->count()
            ];
    
            $response = "📊 Estadísticas de Citas:\n\n";
            $response .= "📅 Citas hoy: {$stats['today']}\n";
            $response .= "⏳ Pendientes: {$stats['pending']}\n";
            $response .= "✅ Completadas: {$stats['completed']}\n";
            $response .= "❌ Canceladas: {$stats['cancelled']}\n";
            $response .= "📈 Total: {$stats['total']}\n";
    
            return $response;
        } catch (\Exception $e) {
            Log::error('Error generando estadísticas:', ['error' => $e->getMessage()]);
            return "No pude generar las estadísticas en este momento. ¿Desea intentar otra consulta? 🤔";
        }
    }

    public function index()
    {
        return view('chat.chat');
    }
    public function sendMessage(Request $request)
    {
        try {
            Log::info('Mensaje recibido:', $request->all());

            if (empty($request->message) || empty($request->user_type)) {
                throw new \Exception('Faltan datos requeridos');
            }

            $message = strtolower(trim($request->message));
            $userType = $request->user_type;

            // Determinar la intención y procesar
            $intent = $this->determineIntent($message);
            $response = $this->processIntent($intent, $message, $userType);

            // Si la respuesta ya es un objeto Response, devolverlo directamente
            if ($response instanceof \Illuminate\Http\JsonResponse) {
                return $response;
            }

            // Si es un string, convertirlo a formato JSON
            return response()->json([
                'status' => 'success',
                'message' => $response
            ]);

        } catch (\Exception $e) {
            Log::error('Error en ChatbotController:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Lo siento, ha ocurrido un error. Por favor, intenta de nuevo.'
            ], 500);
        }
    }

    protected function determineIntent($message)
    {
        $intents = [
            'completed_appointments' => [
                'citas completadas', 'completadas', 'finalizadas', 'atendidas',
                'citas atendidas', 'consultas completadas', 'ver completadas'
            ],
            'pending_appointments' => [
                'citas pendientes', 'pendientes', 'sin completar', 'programadas',
                'por atender', 'sin atender', 'próximas citas', 'ver pendientes'
            ],
            'cancelled_appointments' => [
                'citas canceladas', 'canceladas', 'anuladas', 'ver canceladas',
                'mostrar canceladas', 'citas anuladas'
            ],
            'schedule_appointment' => [
                'agendar cita', 'nueva cita', 'programar cita', 'crear cita',
                'registrar cita', 'agendar consulta', 'programar consulta'
            ],
            'patient_info' => [
                'información paciente', 'datos paciente', 'buscar paciente',
                'historial paciente', 'expediente paciente', 'información del paciente',
                'datos del paciente', 'buscar al paciente'
            ],
            'statistics' => [
                'estadísticas', 'totales', 'números', 'resumen', 'conteo', 
                'métricas', 'datos generales', 'mostrar estadísticas', 
                'ver totales', 'ver estadísticas'
            ],
            'appointment_status' => [
                'estado cita', 'verificar cita', 'consultar estado',
                'estado de la cita', 'como va la cita', 'revisar cita',
                'estado de cita', 'verificar estado'
            ],
            'show_agenda' => [
                'mostrar agenda', 'ver citas', 'agenda del día', 'ver agenda',
                'consultar agenda', 'mostrar citas', 'agenda de hoy',
                'citas de hoy', 'agenda', 'calendario'
            ],
            'help' => [
                'ayuda', 'opciones', 'que puedes hacer', 'comandos',
                'instrucciones', 'guía', 'tutorial', 'mostrar ayuda',
                'necesito ayuda', 'mostrar comandos', 'ver comandos'
            ]
        ];

        // Preprocesar el mensaje
        $message = strtolower(trim($message));
        
        // Buscar coincidencias exactas primero
        foreach ($intents as $intent => $patterns) {
            if (in_array($message, $patterns)) {
                Log::info("Intent encontrado (coincidencia exacta): $intent");
                return $intent;
            }
        }

        // Si no hay coincidencia exacta, buscar coincidencias parciales
        foreach ($intents as $intent => $patterns) {
            foreach ($patterns as $pattern) {
                if (str_contains($message, $pattern)) {
                    Log::info("Intent encontrado (coincidencia parcial): $intent");
                    return $intent;
                }
            }
        }

        Log::info("No se encontró intent específico para el mensaje: $message");
        return 'unknown';
    }
    
    protected function processIntent($intent, $message, $userType)
    {
        Log::info("Procesando intent: $intent", [
            'message' => $message,
            'userType' => $userType
        ]);

        return match ($intent) {
            'completed_appointments' => $this->getCompletedAppointments(),
            'pending_appointments' => $this->getPendingAppointments(),
            'cancelled_appointments' => $this->getCancelledAppointments(),
            'schedule_appointment' => $this->getScheduleAppointmentResponse($userType),
            'patient_info' => $this->getPatientInfo($message),
            'statistics' => $this->getAppointmentStats(),
            'appointment_status' => $this->getSpecificAppointmentStatus($message),
            'help' => $this->getHelpMessage($userType),
            'show_agenda' => $this->getAgendaResponse($message),
            'unknown' => $this->getResponse($message, $userType),
        };
    }
    protected function getScheduleAppointmentResponse($userType)
    {
        if ($userType === 'doctor') {
            return "Para agendar una cita, por favor contacte con recepción o use el sistema de agenda. 👨‍⚕️";
        }

        return "Para agendar una nueva cita necesito los siguientes datos:\n\n" .
               "1️⃣ Nombre completo del paciente\n" .
               "2️⃣ Número de contacto\n" .
               "3️⃣ Fecha y hora deseada\n" .
               "4️⃣ Doctor preferido\n\n" .
               "¿Tiene esta información disponible? 📋";
    }





    protected function getHelpMessage($userType)
    {
        $commonCommands = [
            "📅 Ver agenda: 'mostrar agenda', 'ver citas'",
            "📊 Ver estadísticas: 'mostrar estadísticas', 'totales'",
            "⏳ Citas pendientes: 'citas pendientes', 'pendientes'",
            "✅ Citas completadas: 'citas completadas', 'completadas'",
            "❌ Salir: 'adios', 'hasta luego'"
        ];

        $response = "🤖 Comandos disponibles:\n\n";
        foreach ($commonCommands as $command) {
            $response .= $command . "\n";
        }
        
        $response .= "\nPuede usar estos comandos en cualquier momento. 💫";
        
        return $response;
    }

    protected function getSpecificAppointmentStatus($message)
    {
        try {
            // Extraer nombre del paciente o fecha del mensaje
            preg_match('/(?:de|para|del)\s+([^\s]+(?:\s+[^\s]+)*)/i', $message, $matches);
            
            if (empty($matches[1])) {
                return "Por favor, indique el nombre del paciente o la fecha para verificar la cita. 🔍";
            }

            $searchTerm = $matches[1];
            $isDate = preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $searchTerm);

            $query = DB::table('appointments')
                ->join('doctors', 'appointments.doctor_id', '=', 'doctors.id');

            if ($isDate) {
                $query->whereDate('appointment_time', Carbon::createFromFormat('d/m/Y', $searchTerm));
            } else {
                $query->where('patient_name', 'LIKE', "%{$searchTerm}%");
            }

            $appointments = $query->orderBy('appointment_time')->get();

            if ($appointments->isEmpty()) {
                return "No se encontraron citas para: {$searchTerm}. 🔍";
            }

            $response = "📋 Estado de citas:\n\n";
            foreach ($appointments as $appointment) {
                $fecha = Carbon::parse($appointment->appointment_time)->format('d/m/Y');
                $hora = Carbon::parse($appointment->appointment_time)->format('H:i');
                
                $response .= "📅 Fecha: {$fecha}\n";
                $response .= "⏰ Hora: {$hora}\n";
                $response .= "👤 Paciente: {$appointment->patient_name}\n";
                $response .= "👨‍⚕️ Doctor: {$appointment->doctor_name}\n";
                $response .= "📋 Estado: " . $this->getStatusEmoji($appointment->status) . "\n";
                $response .= "──────────────\n";
            }

            return $response;

        } catch (\Exception $e) {
            Log::error('Error al verificar estado de cita:', ['error' => $e->getMessage()]);
            return "Lo siento, hubo un problema al consultar el estado de la cita. 😕";
        }
    }

    protected function getPatientInfo($message)
    {
        try {
            // Extraer nombre del paciente del mensaje
            $patternNames = array_merge(
                $this->responses['doctor']['buscar_paciente']['patrones'],
                ['información del paciente', 'datos del paciente']
            );
            
            $patientName = null;
            foreach ($patternNames as $pattern) {
                if (str_contains($message, $pattern)) {
                    $patientName = trim(str_replace($pattern, '', $message));
                    break;
                }
            }

            if (empty($patientName)) {
                return "Por favor, indique el nombre del paciente que desea consultar. 🔍";
            }

            $appointments = DB::table('appointments')
                ->join('doctors', 'appointments.doctor_id', '=', 'doctors.id')
                ->where('patient_name', 'LIKE', "%{$patientName}%")
                ->orderBy('appointment_time', 'desc')
                ->get();

            if ($appointments->isEmpty()) {
                return "No se encontró información para el paciente: {$patientName}. 🔍";
            }

            $response = "📋 Información del paciente {$patientName}:\n\n";
            $lastAppointment = $appointments->first();
            
            $response .= "📱 Contacto: {$lastAppointment->patient_contact}\n";
            $response .= "🏥 Historial de citas:\n\n";

            foreach ($appointments as $appointment) {
                $fecha = Carbon::parse($appointment->appointment_time)->format('d/m/Y');
                $response .= "📅 {$fecha}\n";
                $response .= "👨‍⚕️ Dr. {$appointment->doctor_name}\n";
                $response .= "📋 Estado: " . $this->getStatusEmoji($appointment->status) . "\n";
                if ($appointment->appointment_notes) {
                    $response .= "📝 Notas: {$appointment->appointment_notes}\n";
                }
                $response .= "──────────────\n";
            }

            return $response;

        } catch (\Exception $e) {
            Log::error('Error al obtener información del paciente:', ['error' => $e->getMessage()]);
            return "Lo siento, hubo un problema al consultar la información del paciente. 😕";
        }
    }

    protected function getPendingAppointments()
    {
        try {
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

        } catch (\Exception $e) {
            Log::error('Error al obtener citas pendientes:', ['error' => $e->getMessage()]);
            return "Lo siento, hubo un problema al consultar las citas pendientes. 😕";
        }
    }

    protected function getCompletedAppointments()
    {
        try {
            Log::info('Consultando citas completadas');
            
            $appointments = DB::table('appointments')
                ->join('doctors', 'appointments.doctor_id', '=', 'doctors.id')
                ->select('appointments.*', 'doctors.name as doctor_name')
                ->where('appointments.status', 'completed')
                ->orderBy('appointments.appointment_time', 'desc')
                ->get();

            if ($appointments->isEmpty()) {
                return "No hay citas completadas para mostrar. 📋";
            }

            $response = "📋 Citas Completadas:\n\n";
            foreach ($appointments as $appointment) {
                $fecha = Carbon::parse($appointment->appointment_time)->format('d/m/Y');
                $hora = Carbon::parse($appointment->appointment_time)->format('H:i');
                
                $response .= "📅 Fecha: {$fecha}\n";
                $response .= "⏰ Hora: {$hora}\n";
                $response .= "👤 Paciente: {$appointment->patient_name}\n";
                $response .= "👨‍⚕️ Doctor: {$appointment->doctor_name}\n";
                $response .= "📱 Contacto: {$appointment->patient_contact}\n";
                if ($appointment->appointment_notes) {
                    $response .= "📝 Notas: {$appointment->appointment_notes}\n";
                }
                $response .= "──────────────\n";
            }

            return $response;

        } catch (\Exception $e) {
            Log::error('Error al obtener citas completadas:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return "Lo siento, hubo un problema al consultar las citas completadas. 😕";
        }
    }
    protected function getCancelledAppointments()
    {
        try {
            Log::info('Consultando citas canceladas');
            
            $appointments = DB::table('appointments')
                ->join('doctors', 'appointments.doctor_id', '=', 'doctors.id')
                ->select('appointments.*', 'doctors.name as doctor_name')
                ->where('appointments.status', 'cancelled')
                ->orderBy('appointments.appointment_time', 'desc')
                ->get();

            if ($appointments->isEmpty()) {
                return "No hay citas canceladas para mostrar. 📋";
            }

            $response = "📋 Citas Canceladas:\n\n";
            foreach ($appointments as $appointment) {
                $fecha = Carbon::parse($appointment->appointment_time)->format('d/m/Y');
                $hora = Carbon::parse($appointment->appointment_time)->format('H:i');
                
                $response .= "📅 Fecha: {$fecha}\n";
                $response .= "⏰ Hora: {$hora}\n";
                $response .= "👤 Paciente: {$appointment->patient_name}\n";
                $response .= "👨‍⚕️ Doctor: {$appointment->doctor_name}\n";
                $response .= "📱 Contacto: {$appointment->patient_contact}\n";
                if ($appointment->appointment_notes) {
                    $response .= "📝 Notas: {$appointment->appointment_notes}\n";
                }
                $response .= "──────────────\n";
            }

            return $response;

        } catch (\Exception $e) {
            Log::error('Error al obtener citas canceladas:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return "Lo siento, hubo un problema al consultar las citas canceladas. 😕";
        }
    }

    protected function isAgendaQuery($message)
    {
        $keywords = [
            'mostrar agenda', 'ver agenda', 'consultar agenda',
            'ver citas', 'mostrar citas', 'que citas tengo',
            'citas pendientes', 'proximas citas', 'agenda del dia'
        ];
    
        $message = strtolower($message);
        foreach ($keywords as $keyword) {
            if (str_contains($message, $keyword)) {
                Log::info('Detectada consulta de agenda:', ['mensaje' => $message]);
                return true;
            }
        }
    
        return false;
    }

    protected function getAgendaResponse($message = '')
    {
        try {
            Log::info('Iniciando consulta de agenda');
            
            $appointments = DB::table('appointments')
                ->whereDate('appointment_time', '>=', Carbon::today())
                ->orderBy('appointment_time')
                ->get();
                
            Log::info('Citas encontradas:', ['count' => $appointments->count()]);
    
            if ($appointments->isEmpty()) {
                return 'No hay citas programadas para hoy o los próximos días. 📅';
            }
    
            $response = "📅 Estas son las citas programadas:\n\n";
    
            foreach ($appointments as $appointment) {
                $fecha = Carbon::parse($appointment->appointment_time)->format('d/m/Y');
                $hora = Carbon::parse($appointment->appointment_time)->format('H:i');
                
                $response .= "📍 Fecha: {$fecha}\n";
                $response .= "⏰ Hora: {$hora}\n";
                $response .= "👤 Paciente: {$appointment->patient_name}\n";
                
                if (isset($appointment->doctor_id)) {
                    try {
                        $doctor = DB::table('doctors')
                            ->where('id', $appointment->doctor_id)
                            ->first();
                        if ($doctor) {
                            $response .= "👨‍⚕️ Doctor: {$doctor->name}\n";
                        }
                    } catch (\Exception $e) {
                        Log::error('Error al consultar doctor:', ['error' => $e->getMessage()]);
                    }
                }
                
                $response .= "📞 Contacto: {$appointment->patient_contact}\n";
                $response .= "📋 Estado: " . $this->getStatusEmoji($appointment->status) . "\n";
                $response .= "──────────────\n";
            }
    
            return $response;
    
        } catch (\Exception $e) {
            Log::error('Error detallado al consultar agenda:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
    
            return 'Disculpe, estoy teniendo dificultades para acceder a la agenda. Por favor, inténtelo nuevamente. 🔄';
        }
    }
    
    protected function determineQueryType($message)
    {
        $message = strtolower($message);
        
        $patterns = [
            'today' => [
                'hoy', 'del dia', 'para hoy', 'este dia',
                'actual', 'presente dia', 'en el dia'
            ],
            'tomorrow' => [
                'mañana', 'siguiente dia', 'proximo dia'
            ],
            'week' => [
                'semana', 'esta semana', 'proxima semana', 
                'siguientes dias', 'proximos dias'
            ],
            'pending' => [
                'pendiente', 'por atender', 'sin completar',
                'programada', 'agendada', 'sin realizar'
            ],
            'next' => [
                'proxima', 'siguiente', 'que sigue',
                'posterior', 'mas cercana', 'cercana'
            ]
        ];

        foreach ($patterns as $type => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($message, $keyword)) {
                    return $type;
                }
            }
        }

        return 'default';
    }

    protected function getStatusEmoji($status)
    {
        return match ($status) {
            'scheduled' => '⏳ Programada',
            'completed' => '✅ Completada',
            'cancelled' => '❌ Cancelada',
            'pending' => '📋 Pendiente',
            'in_progress' => '🔄 En Proceso',
            'delayed' => '⚠️ Retrasada',
            default => '❓ Desconocido'
        };
    }

    protected function getResponse($message, $userType)
    {
        foreach ($this->responses[$userType] as $category => $data) {
            foreach ($data['patrones'] as $patron) {
                if (str_contains($message, $patron)) {
                    $respuestas = $data['respuestas'];
                    return $respuestas[array_rand($respuestas)];
                }
            }
        }

        // Si no encuentra patrón, dar respuesta general
        return "¿En qué más puedo ayudarte? 🤔";
    }
}
            