<?php
// app/Http/Middleware/IsCustomer.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsCustomer
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        // 🎯 CEK: Apakah user adalah customer?
        if (Auth::user()->role !== 'customer') {
            // Jika bukan customer, redirect ke admin dashboard
            return redirect()->route('admin.dashboard')
                ->with('error', 'Halaman ini hanya untuk customer.');
        }
        
        return $next($request);
    }
}