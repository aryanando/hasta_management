<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateToAPI
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $status = $this->checkToken(session('token'));
        if ($status) {
            return $next($request);
        } else {
            return redirect('/login');
        }
    }

    function checkToken($token)
    {
        $response = Http::acceptJson()
            ->withToken($token)
            ->get(env('API_URL') . '/api/v1/me');
        if ($response->successful()) {
            session(['user_data' => json_decode($response)->data]);
            return true;
        } else {
            return false;
        }
    }
}
