```html
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asistente Médico Virtual</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f5f7fb;
        }

        .back-button-container {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: white;
            z-index: 10;
            padding: 0.75rem 1.5rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .back-button {
            display: flex;
            align-items: center;
            color: #374151;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .back-button i {
            margin-right: 0.5rem;
            font-size: 1rem;
        }

        .back-button:hover {
            color: #2563eb;
        }

        .chat-container {
            background: linear-gradient(135deg, #f6f9fc 0%, #ffffff 100%);
            height: calc(100vh - 2rem);
            padding-top: 60px;
        }

        .message-bubble {
            position: relative;
            padding: 1rem;
            border-radius: 1rem;
            max-width: 80%;
            animation: fadeIn 0.3s ease-out;
            margin-bottom: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            white-space: pre-line;
        }

        .message-bubble.user {
            background: #1a73e8;
            color: white;
            margin-left: auto;
            border-bottom-right-radius: 0.25rem;
        }

        .message-bubble.bot {
            background: white;
            border: 1px solid #e2e8f0;
            margin-right: auto;
            border-bottom-left-radius: 0.25rem;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .typing-indicator {
            display: flex;
            padding: 1rem;
            gap: 0.5rem;
        }

        .typing-dot {
            width: 8px;
            height: 8px;
            background: #1a73e8;
            border-radius: 50%;
            animation: typing 1s infinite ease-in-out;
        }

        .typing-dot:nth-child(2) { animation-delay: 0.2s; }
        .typing-dot:nth-child(3) { animation-delay: 0.4s; }

        @keyframes typing {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #1a73e8;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <!-- Back Button -->
    <div class="back-button-container">
        <a href="http://localhost:8084/appointments" class="back-button">
            <i class="fas fa-chevron-left"></i>
            Volver al inicio
        </a>
    </div>

    <div class="chat-container mx-auto max-w-4xl p-4">
        <!-- Chat Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-t-xl shadow-lg p-6 flex items-center gap-4 text-white">
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <i class="fas fa-robot text-white text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold">Asistente Médico Virtual</h1>
                <p class="text-blue-100">Sistema de Asistencia Médica</p>
            </div>
        </div>

        <!-- Chat Messages Container -->
        <div class="bg-white shadow-lg rounded-b-xl flex flex-col h-[calc(100vh-16rem)]">
            <div id="chat-messages" class="flex-1 p-6 overflow-y-auto space-y-4 custom-scrollbar"></div>

            <!-- Typing Indicator -->
            <div id="typing-indicator" class="typing-indicator hidden mx-6">
                <div class="typing-dot"></div>
                <div class="typing-dot"></div>
                <div class="typing-dot"></div>
            </div>

            <!-- Chat Input -->
            <div class="border-t p-4 bg-gray-50 rounded-b-xl">
                <form id="chat-form" class="flex gap-4">
                    <select id="user-type" class="rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 bg-white">
                        <option value="doctor">Doctor</option>
                        <option value="receptionist">Recepcionista</option>
                    </select>
                    <input type="text" 
                           id="message-input" 
                           class="flex-1 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                           placeholder="Escribe tu mensaje...">
                    <button type="submit" 
                            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 flex items-center gap-2">
                        <span>Enviar</span>
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('chat-form');
            const messagesContainer = document.getElementById('chat-messages');
            const messageInput = document.getElementById('message-input');
            const userTypeSelect = document.getElementById('user-type');
            const typingIndicator = document.getElementById('typing-indicator');

            // Función mejorada para mostrar mensajes
            function addMessage(message, type) {
                const div = document.createElement('div');
                div.className = `message-bubble ${type}`;
                div.textContent = message;
                messagesContainer.appendChild(div);
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }

            // Función para manejar errores
            function handleError(error) {
                console.error('Error detallado:', error);
                typingIndicator.classList.add('hidden');
                addMessage('Error de comunicación: ' + error.message, 'bot');
            }

            // Función principal para enviar mensajes
            async function sendChatMessage(message, userType) {
                try {
                    const response = await fetch('/chat/send', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            message: message,
                            user_type: userType
                        })
                    });

                    // Log para debugging
                    console.log('Respuesta del servidor:', response);

                    if (!response.ok) {
                        throw new Error(`Error HTTP: ${response.status}`);
                    }

                    const data = await response.json();
                    console.log('Datos recibidos:', data);

                    return data;
                } catch (error) {
                    console.error('Error en sendChatMessage:', error);
                    throw error;
                }
            }

            // Manejador del formulario
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const message = messageInput.value.trim();
                if (!message) return;

                // Mostrar mensaje del usuario
                addMessage(message, 'user');
                messageInput.value = '';
                
                // Mostrar indicador de escritura
                typingIndicator.classList.remove('hidden');

                try {
                    console.log('Enviando mensaje:', message);
                    const data = await sendChatMessage(message, userTypeSelect.value);
                    
                    typingIndicator.classList.add('hidden');

                    if (data.status === 'success') {
                        addMessage(data.message, 'bot');
                    } else {
                        throw new Error(data.message || 'Error desconocido');
                    }

                } catch (error) {
                    handleError(error);
                }
            });

            // Manejo de Enter para enviar mensaje
            messageInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    form.dispatchEvent(new Event('submit'));
                }
            });

            // Debug inicial
            console.log('Chat inicializado');
            console.log('CSRF Token:', document.querySelector('meta[name="csrf-token"]').content);
        });
    </script>
</body>
</html>
```