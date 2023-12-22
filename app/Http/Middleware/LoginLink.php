<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class LoginLink
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
        if (!$request->hasValidSignature()) {
            Mail::to($request->email)->send(
                new \App\Mail\LoginLink(URL::temporarySignedRoute('login.store', 3600, ['email' => $request->email]))
            );

            return redirect('login-link');
        }

        return $next($request);
    }
}
