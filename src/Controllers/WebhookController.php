<?php

namespace TripUp\Cache\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function resetCache(Request $request)
    {
        Log::debug($request->all());
        return "Ok";
    }
}
