<?php

namespace Neo\PusherLogger;

use Pusher\Pusher;
use Illuminate\Support\ServiceProvider;
use Pusher\PushNotifications\PushNotifications;

class PusherLoggerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('pusher-logger', function () {
            $config = config('broadcasting.connections.pusher');

            $key = $config['key'] ?? '';
            $secret = $config['secret'] ?? '';
            $app_id = $config['app_id'] ?? '';

            $pusher = new Pusher($key, $secret, $app_id, [
                'useTLS' => true,
                'encrypted' => true,
                'cluster' => $config['options']['cluster'] ?? '',
            ]);

            $beams = new PushNotifications([
                'secretKey' => $config['beams']['secret_key'] ?? '',
                'instanceId' => $config['beams']['instance_id'] ?? '',
            ]);

            return new PusherLogger($pusher, $beams);
        });
    }
}
