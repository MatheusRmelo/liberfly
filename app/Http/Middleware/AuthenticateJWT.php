<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponse;
use Closure;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\ExpiredException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateJWT
{
    use ApiResponse;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
        if(!$token){
            return $this->unauthorized(null, 'Token não informado');
        }
        try {
            $decoded = JWT::decode($token, new Key(env('JWT_SECRET_KEY'), 'HS256'));
            //$request->merge(['user' => $decoded]);
            $request->merge(["customer" => (array) $decoded]);
            return $next($request);
        }catch (ExpiredException $error){
            return $this->unauthorized(null, 'Token expirado');
        }catch (SignatureInvalidException $error){
            return $this->unauthorized(null, 'Token inválido');
        }catch (Exception $error){
            dd($error);
            return $this->serverFailed(null);
        }
    }
}
