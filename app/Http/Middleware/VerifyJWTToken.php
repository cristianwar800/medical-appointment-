<?php

namespace App\Http\Middleware;

use Closure;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;

class VerifyJWTToken
{
    public function handle($request, Closure $next)
    {
        try {
            // Intentar obtener el token de diferentes fuentes
            $token = $request->bearerToken() ?? $request->cookie('jwt_token') ?? session('jwt_token');
            
            if (!$token) {
                return response()->json(['message' => 'Token no encontrado'], 401);
            }

            JWTAuth::setToken($token);
            
            if (!$user = JWTAuth::authenticate()) {
                return response()->json(['message' => 'Usuario no encontrado'], 404);
            }

            return $next($request);

        } catch (TokenExpiredException $e) {
            return response()->json(['message' => 'Token expirado'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['message' => 'Token inválido'], 401);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al verificar token'], 401);
        }
    }
}