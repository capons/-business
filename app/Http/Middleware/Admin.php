<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Lang;

class Admin {
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;
    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                Session::flash('user-info', Lang::get('error.auth.need_auth'));  //if user do not login

                return redirect()->guest('auth/login');
            }
        }

        if ( Auth::check() && Auth::user()->access == 2 ) //check if login and have admin rights
        {
            return $next($request);
        }
        Session::flash('user-info', Lang::get('error.auth.no_access'));  //if user do not login
        return redirect()->guest('auth/login');
        //return $next($request);
    }
}