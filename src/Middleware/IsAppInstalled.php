<?php

namespace Digitalbit\LaravelInstaller\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAppInstalled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $urlSegments = $request->path();
        if(config('laravelinstaller.status') !== true) {
            return redirect('/install');
        }
        return $next($request);
    }
}
