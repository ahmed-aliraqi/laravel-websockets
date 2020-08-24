<?php

namespace BeyondCode\LaravelWebSockets\Contracts;

use BeyondCode\LaravelWebSockets\PubSub\Broadcasters\RedisPusherBroadcaster;
use Illuminate\Broadcasting\Broadcasters\PusherBroadcaster;
use Pusher\Pusher;

trait PushesToPusher
{
    /**
     * Get the right Pusher broadcaster for the used driver.
     *
     * @param  array  $app
     * @return \Illuminate\Broadcasting\Broadcasters\Broadcaster
     */
    public function getPusherBroadcaster(array $app)
    {
        if (config('websockets.replication.driver') === 'redis') {
            return new RedisPusherBroadcaster(
                new Pusher($app['key'], $app['secret'], $app['id'], config('broadcasting.connections.websockets.options', [])),
                $app['id'],
                app('redis'),
                config('broadcasting.connections.websockets.connection', null)
            );
        }

        return new PusherBroadcaster(
            new Pusher($app['key'], $app['secret'], $app['id'], config('broadcasting.connections.pusher.options', []))
        );
    }
}