<?php

namespace App\Http\Middleware;

use Closure;

class Admin
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
        if(!$request->hasCookie("admin")){
            // Todo: Cookie Wert in Session-Tabelle und abgleichen!
            return redirect("admin/login");
        }
        return $next($request);
    }
}
