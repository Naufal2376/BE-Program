<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        $user = Auth::user();

        if (!$user || !method_exists($user, 'is' . ucfirst($role)) || !$user->{'is' . ucfirst($role)}()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}