<?php

namespace App\Http\Middleware;

use Closure;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Http\Request;

class VerifyJWTToken
{
    public function handle(Request $request, Closure $next)
    {
        try {
            // Intentar obtener el token de diferentes fuentes
            $token = $request->bearerToken() ?? 
                    $request->cookie('jwt_token') ?? 
                    $request->header('Authorization') ?? 
                    $request->input('token');

            if (!$token && $request->ajax()) {
                return response()->json(['message' => 'Token no encontrado'], 401);
            }

            if (!$token) {
                return redirect()->to('http://localhost:8082/login');
            }

            // Si el token viene como "Bearer token", extraer solo el token
            if (strpos($token, 'Bearer ') === 0) {
                $token = substr($token, 7);
            }

            JWTAuth::setToken($token);
            
            if (!$user = JWTAuth::authenticate()) {
                if ($request->ajax()) {
                    return response()->json(['message' => 'Usuario no encontrado'], 401);
                }
                return redirect()->to('http://localhost:8082/login');
            }

            // Almacenar el usuario en la request para uso posterior
            $request->merge(['user' => $user]);
            
            return $next($request);

        } catch (TokenExpiredException $e) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Token expirado'], 401);
            }
            return redirect()->to('http://localhost:8082/login');
        } catch (TokenInvalidException $e) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Token inválido'], 401);
            }
            return redirect()->to('http://localhost:8082/login');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Error al verificar token'], 401);
            }
            return redirect()->to('http://localhost:8082/login');
        }
    }
}