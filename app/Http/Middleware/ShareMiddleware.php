<?php

namespace App\Http\Middleware;

use App\Models\Page;
use Closure;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShareMiddleware
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
        $navbar_pages = Page::getByUserAndVisibility($request->user(), true);
        \View::share('navbar_pages', $navbar_pages);
        \View::share('session_vars', [
            'admin_id' => \session()->get('admin_id')
        ]);
        return $next($request);
    }
}
