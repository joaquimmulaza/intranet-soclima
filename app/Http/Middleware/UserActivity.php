<?php

namespace App\Http\Middleware;

use App\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UserActivity
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
        if(Auth::check()){
            // keep online for 1 min
            $expireTime = Carbon::now()->addMinute(2);
            Cache::put('is_online'.Auth::user()->id, true, $expireTime);

            /*Last Seen
            Carbon::today()
            Carbon::now()
            */
            User::where('id', Auth::user()->id)->update(['ultimo_acesso' => Carbon::now()]);
        }

        return $next($request);
    }
}
