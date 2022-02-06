<?php

namespace TripUp\Cache\Controllers;

use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Bus;
use TripUp\Cache\Contracts\RequestTagResolver;
use TripUp\Cache\Contracts\ResponseTagResolver;

class WebhookController extends Controller
{

    public function resetCache(Request $request, RequestTagResolver $resolver)
    {
        $tags = $resolver->resolveTags($request);
        $webhookJobs = config("tagcache.webhook_jobs");
        foreach ($webhookJobs as $jobClass) {
            Bus::dispatch(app($jobClass,["tags"=>$tags, "data"=>$request->all()]));
        }
        return response()->json("Ok");
    }
}
