<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ShareUser
{

    public function handle(Request $request, Closure $next): Response
    {
        view()->share('user', Auth::user());

        return $next($request);
    }
}
