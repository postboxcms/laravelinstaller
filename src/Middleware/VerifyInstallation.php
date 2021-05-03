<?php

namespace Postbox\LaravelInstaller\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyInstallation
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

        if(config('laravelinstaller.installed') !== "1" && strpos('/'.$urlSegments, 'install') === false) {
            return redirect('/install');
        }
        return $next($request);
    }
}
