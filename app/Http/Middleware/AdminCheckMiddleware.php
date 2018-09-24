<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminCheckMiddleware
{
    protected $auth;

    /**
     * Creates a new instance of the middleware.
     *
     * @param Guard $auth
     */
    public function __construct()
    {
        
    }
    public function handle(Request $request, Closure $next)
    {
        if ( empty( session('staff_object_session') ) ) {
            return redirect()->action('LoginController@login');
        }
        return $next($request);
    }
}
