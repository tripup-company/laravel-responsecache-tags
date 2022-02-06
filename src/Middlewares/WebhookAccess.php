<?php

namespace TripUp\Cache\Middlewares;

class WebhookAccess
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        if ($request->input('key') !== config("tagcache.webhook_secret")) {
            abort(401, "Wrong secret key!");
        }

        return $next($request);
    }

}
