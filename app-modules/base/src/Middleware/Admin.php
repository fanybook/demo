<?php

namespace Modules\Base\Middleware;

use Closure;
use Auth;
use Session;

class Admin
{
    public function handle($request, Closure $next, $guard = null)
    {
        $auth = false;

        if (Auth::check() && Session::get('admin_auth')
          && time() - Session::get('admin_auth') < 60*15) {
            $auth = true;
        }

        if (!$auth) {
            if ($request->ajax()) {
                return ['auth' => 'timeout'];
            } else {
                return redirect()->guest(config('backpack.base.route_prefix', 'admin').'/login');
            }
        }

        Session::set('admin_auth', time());

        return $next($request);
    }
}
