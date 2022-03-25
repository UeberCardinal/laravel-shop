<?php

namespace App\Http\Middleware;

use App\Models\Promocode;
use Closure;
use Illuminate\Http\Request;

class CheckPromocode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $promocode = Promocode::where('name', $request->promocode)->get();
        if ($promocode->count()) {
            return $next($request);
        }
        return back()->with('error', 'Такого промокода не существует');

    }
}
