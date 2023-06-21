<?php

namespace App\Http\Middleware;

use App\Constants\Status;
use Closure;

class CheckStatus
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
        $admin = auth()->guard('admin')->user();
        if ($admin->role != Status::SUPER_ADMIN && $admin->status == Status::DISABLE) {
            return to_route('admin.banned');
        }
        return $next($request);
    }
}
