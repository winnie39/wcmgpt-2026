<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KycVerificationMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = User::find(auth()->id());
        if (!auth()->user()->kyc) {
            $user->kyc()->create();
        }

        if (auth()->user()->verified) {

            return $next($request);
        }

        return redirect('/verification');
    }
}
