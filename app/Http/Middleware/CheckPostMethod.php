<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPostMethod
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
       {
           // Cek apakah metode permintaan adalah POST
           if (!$request->isMethod('post')) {
               // Redirect kembali jika bukan POST
               return redirect()->back()->with('error', 'Akses tidak diizinkan.');
           }

           return $next($request);
       }
}
