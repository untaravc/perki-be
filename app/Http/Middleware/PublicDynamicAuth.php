<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class PublicDynamicAuth
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        $access_token = PersonalAccessToken::findToken($token);

        if ($access_token) {
            $member = $access_token->tokenable;

            if ($member) {
                $request->merge([
                    'logged_user_id'    => $member->id,
                ]);
            }
        }

        return $next($request);
    }
}
