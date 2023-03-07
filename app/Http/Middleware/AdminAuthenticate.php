<?php

namespace App\Http\Middleware;

use App\Enum\RoleEnum;
use App\Models\User;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthenticate extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards): mixed
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user->isRole(RoleEnum::ADMIN)) {
            return redirect()->route('admin.login');
        }

        return $next($request);
    }

    /**
     * @param Request $request
     * @return string|null
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('admin.login');
    }
}
