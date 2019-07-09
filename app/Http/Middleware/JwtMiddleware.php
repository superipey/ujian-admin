<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\Response;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (empty($request->bearerToken())) return Response::unauth();

        try {
            $user = \JWTAuth::parseToken()->authenticate();
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return Response::unauth();
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return Response::unauth();
        } catch (Exception $e) {
            return Response::unauth('Authorization Token not found');
        }
        return $next($request);
    }
}
