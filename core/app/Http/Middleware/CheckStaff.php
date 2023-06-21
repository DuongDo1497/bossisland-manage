<?php

namespace App\Http\Middleware;

use App\Constants\Status;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckStaff
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
        $admin = auth()->guard('admin')->user();

        if ($admin->role == Status::STAFF) {

            if ($admin->status == Status::DISABLE) {
                return to_route('admin.banned');
            }

            $notify[] = ['error', 'You are not eligible for this action'];
            return to_route('admin.dashboard')->withNotify($notify);
        }

        return $next($request);
    }
}
