<?php

namespace App\Http\Middleware;

use App\UserInformation;
use Closure;
use Illuminate\Support\Facades\Auth;

class UserAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && !UserInformation::userPermissions(Auth::id())['admin']) {
            return abort(404);
        }

        return $next($request);
    }
}
