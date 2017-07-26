<?php

namespace Modules\Base\Middleware;

use Closure;
use Auth;
use Session;

class AdminLogined
{
    public function handle($request, Closure $next, $guard = null)
    {
        $auth = false;

        if (Auth::check() && Session::get('admin_auth')
          && time() - Session::get('admin_auth') < 60*15) {
            $auth = true;
        }

        if ($auth) {
            if (Session::get('admin_role') === 'admin') {
                return redirect(config('backpack.base.route_prefix', 'admin'));
            }
        }

        return $next($request);
    }
}
