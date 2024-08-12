<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
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
            $responseData =json_decode($response)->data;
            if ($responseData->name !== 'Administrator') {
                if($responseData->unit[0]->unit_leader_id == $responseData->id){
                    $responseData->karu = true;
                }else{
                    $responseData->karu = false;
                }
            }else{
                $responseData->karu = false;
            }
            if ($responseData->id == 1 || $responseData->id == 188) {
                session(['user_data' => $responseData]);
                return true;
            }

            session(['user_data' => $responseData]);
            return true;
        } else {
            return false;
        }
    }
}
