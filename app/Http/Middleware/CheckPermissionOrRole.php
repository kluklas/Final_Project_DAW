<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermissionOrRole
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = Auth::user();

        // Verifica si el usuario tiene el permiso o el rol
        if ($user->hasRole('Admin')) {
            return $next($request);
        }

        // Si no tiene permiso ni el rol, devuelve un error 403
        abort(403, 'No tienes autorización para acceder a esta página.');
    }
}
