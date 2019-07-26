<?php

namespace App\Http\Middleware;

use Closure;

class ConfirmEmail
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // if ($request->user() && !$request->user()->confirmed())
        //     return (redirect('verify'));

        return $next($request);
    }
}
