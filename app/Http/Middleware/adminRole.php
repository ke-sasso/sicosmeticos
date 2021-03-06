<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Auth;
use Debugbar;
use App\UserOptions;

class adminRole
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
        
        if(Auth::user())
        {
            if(!Auth::user()->hasAnyRole(['admin_it']))
            {
                Debugbar::disable();    
            }
            else
            {
                Debugbar::enable();
            }

        }
        return $next($request);
    }
}
