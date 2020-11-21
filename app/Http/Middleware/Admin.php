<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Enums\UserType;
use Auth;
class Admin
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
        // return $next($request);
        if(Auth::check()){
            $user = Auth::user();
            if($user->role_id = UserType::Admin){
                return $next($request);
            }
            return redirect('/login');
            // return response()->json([
            //     "status" => false,
            //     "message" => 'Get the fuck out'
            // ]);
        }else{
            return redirect('/login');
            // return response()->json([
            //     "status" => false,
            //     "message" => 'Get the fuck out'
            // ]);
        }
    }
}
