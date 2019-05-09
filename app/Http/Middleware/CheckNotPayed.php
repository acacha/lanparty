<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class CheckNotPayed
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
        if (in_array(config('lanparty.session'),Auth::user()->inscription_paid)) abort(422, 'NO és possible registrar-se un cop ja has pagat la inscripció! Dirigeix-te a recepció per tornar a gestionar el pagament');
        return $next($request);
    }
}
