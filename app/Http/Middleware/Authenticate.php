<?php

namespace Clay\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{

	public function handle($request, \Closure $next, ...$guards) {
		try {
			$this->authenticate($request, $guards);
		} catch (AuthenticationException $ex) {

			if($request->expectsJson()) {
				return response()->json([
					'status' => 'failed',
					'reason' => 'not_allowed',
				], 403);
			}

			throw $ex;
		}

		return $next($request);
	}


    protected function redirectTo($request)
    {
        return route('auth.index');
    }
}
