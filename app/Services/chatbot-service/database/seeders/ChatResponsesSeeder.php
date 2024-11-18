<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ChatResponsesSeeder extends Seeder
{
    public function run()
    {
        $responses = [
            [
                'session_id' => (string) Str::uuid(),
                'message' => '¡Bienvenido Doctor! ¿En qué puedo ayudarte hoy?',
                'type' => 'bot',
                'user_type' => 'doctor',
                'intent' => 'greeting',
                'context' => json_encode(['type' => 'initial']),
                'resolved' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'session_id' => (string) Str::uuid(),
                'message' => '¡Bienvenido! ¿En qué puedo ayudarte hoy?',
                'type' => 'bot',
                'user_type' => 'receptionist',
                'intent' => 'greeting',
                'context' => json_encode(['type' => 'initial']),
                'resolved' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'session_id' => (string) Str::uuid(),
                'message' => 'Consultando tu agenda del día...',
                'type' => 'bot',
                'user_type' => 'doctor',
                'intent' => 'agenda',
                'context' => json_encode(['action' => 'fetch_appointments']),
                'resolved' => false,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'session_id' => (string) Str::uuid(),
                'message' => 'Para agendar una cita necesito los siguientes datos...',
                'type' => 'bot',
                'user_type' => 'receptionist',
                'intent' => 'cita',
                'context' => json_encode(['action' => 'create_appointment']),
                'resolved' => false,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($responses as $response) {
            DB::table('chat_messages')->insert($response);
        }
    }
}