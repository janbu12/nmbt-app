<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $role = Auth::user()->role;

            // Redirect admin to admin dashboard if trying to access non-admin pages
            if ($role === 'admin' && in_array($request->path(), ['/', 'sewa', 'about'])) {
                return redirect('/admin/dashboard');
            }

            // Redirect regular users if trying to access admin-only pages
            if ($role !== 'admin' && $request->is('admin/*')) {
                return redirect('/');
            }
        }

        return $next($request);
    }
}
