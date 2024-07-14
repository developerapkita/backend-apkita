<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserToken;
use Carbon\Carbon;
class ValidateToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header("Authorization");
        if(!$token || !str_replace('Bearer ', '', $token)){
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $token_split = str_replace('Bearer ', '', $token);
        $user = UserToken::where('token', $token_split)->first();
        if(!$user){
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $currentDateTime = Carbon::now();
        if($user->expired_at < $currentDateTime) {
            return response()->json(['message' => 'Token has expired'], 401);
        }
        return $next($request);
    }
}
