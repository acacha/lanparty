<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSession
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
        if (!$this->sessionIsActive($request)) abort(422, 'NO és possible realitzar accions en sessions arxivades.');

        return $next($request);
    }

    protected function sessionIsActive(Request $request)
    {
        $sessions = collect(config('lanparty.sessions'));
        $s = $request->session;
        $foundSession = $sessions->filter(function($session) use ($s) {
            return $session['name'] == $s;
        })->first();
        return !$foundSession['deleted_at'];
    }
}
