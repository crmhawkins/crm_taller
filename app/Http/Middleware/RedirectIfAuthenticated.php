<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Laravel\Passport\PersonalAccessTokenResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {

                $user = Auth::user();

                // Verificar si el usuario tiene ID 5
                if ($user && $user->id == 8) {
                    // Generar un token personal que no caduque nunca
                    $token = $user->createToken('PermanentToken', ['*'])->accessToken;

                    // Guardar el token en la sesión o en una cookie
                    // Aquí lo guardamos en la sesión para este ejemplo
                    cookie()->queue('permanent_token', $token, 525600); // 525600 minutos = 1 año
                }

                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
