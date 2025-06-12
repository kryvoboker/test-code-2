<?php

declare(strict_types = 1);

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TelegramApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next) : Response
    {
        if ($request->query('token') != config('telegram.webhook_secret')) {
            abort(403, 'Unauthorized!');
        }

        return $next($request);
    }
}
