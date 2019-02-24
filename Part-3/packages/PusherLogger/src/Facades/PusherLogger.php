<?php

namespace Neo\PusherLogger\Facades;

use Illuminate\Support\Facades\Facade;

class PusherLogger extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'pusher-logger';
    }
}
