<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EmailVerificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if($user->email_verified_at != null){
            return $next($request);
        }

        return response()->json([
            "response_code" => "01",
            "response_message" => "Email Anda Belum Di verifikasi",
        ], 401);
        // return $next($request);
    }
}
