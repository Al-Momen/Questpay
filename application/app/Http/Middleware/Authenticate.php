<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
       if (! $request->expectsJson()) {
            if (!Auth::check() && $request->isMethod('post') && Route::currentRouteName() == 'user.paper.submit.store') {
                $previousUrl = url()->previous();
                $formData = $request->except(['_token', 'file']);
                session(['intended_data' => $formData]);
            }
            return route('user.login');
        }
    }
}
