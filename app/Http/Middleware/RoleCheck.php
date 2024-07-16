<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RoleAccount;
class RoleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user(); 
       
        $role = RoleAccount::where("id", $user->role)->first();
       
        $role = RoleAccount::where('id', $user->role)->first();
        if (!in_array($role->name_role, $roles)) {
            return redirect('/');
        }
        return $next($request);
    }
}
