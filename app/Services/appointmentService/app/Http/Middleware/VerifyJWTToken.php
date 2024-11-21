<?php

namespace App\Http\Middleware;

use Closure;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Support\Facades\Log;

class VerifyJWTToken
{
    public function handle($request, Closure $next)
    {
        try {
            // Obtener token de todas las fuentes posibles
            $token = $this->getTokenFromRequest($request);

            if (!$token) {
                Log::warning('Token no encontrado');
                return $this->handleInvalidToken($request);
            }

            // Limpiar el token si viene con Bearer
            $token = str_replace('Bearer ', '', $token);

            // Configurar y verificar el token
            JWTAuth::setToken($token);
            $user = JWTAuth::authenticate();
            
            if (!$user) {
                Log::warning('Usuario no encontrado con el token proporcionado');
                return $this->handleInvalidToken($request);
            }

            // Añadir token y usuario a la request
            $request->merge(['auth_user' => $user]);
            $request->headers->set('Authorization', 'Bearer ' . $token);

            // Compartir con las vistas
            view()->share('jwt_token', $token);
            view()->share('auth_user', $user);

            $response = $next($request);

            // Asegurar que el token se mantenga en las cookies
            return $response->withCookie(cookie('jwt_token', $token, 60, '/', 'localhost', false, false));

        } catch (\Exception $e) {
            Log::error('Error en verificación de token: ' . $e->getMessage());
            return $this->handleInvalidToken($request);
        }
    }

    protected function getTokenFromRequest($request)
    {
        return $request->cookie('jwt_token') ?? 
               $request->bearerToken() ?? 
               $request->header('Authorization') ?? 
               $request->input('token') ??
               $_COOKIE['jwt_token'] ?? null;
    }

    protected function handleInvalidToken($request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Guardar la URL actual para redireccionar después del login
        session()->put('url.intended', url()->current());
        
        return redirect()
            ->to('http://localhost:8082/login')
            ->withCookie(cookie()->forget('jwt_token'));
    }
}