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
        $status = $this->checkToken('yJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5Yjk3MTYzYi01MjU3LTQwYTEtYTAwOS05Yjc2NGNjZTY3ZTgiLCJqdGkiOiIwYTcwZjhlZGUwZmJkZWQ0ZjZlMDZkMWY3ZmE5Mzg5ZWVlMWMzZTIzODQ2NjYxNzIzMWRkZjY5ZjVmYjVmZTkzNjg0ZTcxNTAyZjRkMGM3NyIsImlhdCI6MTcxMDgxMTMwMC42MjM2MzE5NTQxOTMxMTUyMzQzNzUsIm5iZiI6MTcxMDgxMTMwMC42MjM2MzQwOTk5NjAzMjcxNDg0Mzc1LCJleHAiOjE3NDIzNDczMDAuNjExMDk5MDA0NzQ1NDgzMzk4NDM3NSwic3ViIjoiMSIsInNjb3BlcyI6W119.ff8eepeDgCdWbI96aSDz1JXoypPmRplJiaprchMDnPlKyIrztqZUI6ee3pBAYm7KFs-gIPBgQGvgIcX8ojpJuuIl6VUZr8dCI2_m0iDbJPF7fsYCqbJMl_eIyXglthRMxrAoNURkRNTW1-GCOuBo7R8w4fHpvUIlIwChyXAtgCqhVkq9KtD3IZaqVCBFILYUWA8TNKu1QVimSHYqP8fVxf_-LOa-MvD4WNOR8CRlr0zvbqThum3BBbQYAYlxMzQq9zAlZpWVeR4eXunLzkyvE8m0D-oK1CGRz3SxyPBTSl9scndK7npNS__uQkrUsf7SGXqLKfc37_bXgSA-5INOZsNLcstRSmPvlbZzC9HS2WNi71IgWdVQmGuafI014hC3hjf96d0800iXu2rSy7jzQTwzCHpFcsVpFoAk0-n7vfWlwjgI002GMwiOC7sTGM_drBH6inhsYtkw_TqwWEQuCZ7iqKzCr_JcmCvuOFWmTwmko8CyWTsXu8PEEo6pivQrXq6T8NDODWhT5FhGW2THcZzsrKDntVlBRuISeRQzDkV-a-N3f6W_aYGpTljf0guPIo6f1BjtY6G7EP1MEwnVQUt1zSJnwMvyjwsbg0FUCQhDqh7R6DUWXD2mq7PBMotGpjQ9W_ZDEsg6kAMAJw7K-T7VrI-jHxlq3ofASo-Fnvw');
        if ($status) {
            echo 'lalala ok';
            return $next($request);
        } else {
            echo 'lalala bad';
            return route('login');
        }
    }

    function checkToken($token)
    {
        $response = Http::acceptJson()
            ->withToken($token)
            ->get(env('API_URL') . '/api/v1/me');
        if ($response->successful()) {
            return true;
        } else {
            return false;
        }
    }
}
