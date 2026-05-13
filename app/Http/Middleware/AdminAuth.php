<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuth
{
  public function handle($request, Closure $next)
{
    if (!session()->has('admin_id')) {
        return redirect()->route('admin.login');
    }

    return $next($request);
}
}