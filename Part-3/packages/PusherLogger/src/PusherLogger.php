<?php

namespace Neo\PusherLogger;

use Pusher\Pusher;
use Pusher\PushNotifications\PushNotifications;

class PusherLogger
{
    /**
     * @var \Pusher\Pusher
     */
    protected $pusher;

    /**
     * @var \Pusher\PushNotifications\PushNotifications
     */
    protected $beams;

    /**
     * @var string
     */
    protected $event;

    /**
     * @var string
     */
    protected $channel;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var string
     */
    protected $level;

    /**
     * @var array
     */
    protected $interests = [];

    // Log levels
    const LEVEL_INFO = 'info';
    const LEVEL_DEBUG = 'debug';
    const LEVEL_ERROR = 'error';

    /**
     * PusherLogger constructor.
     *
     * @param  \Pusher\Pusher $pusher
     * @param  \Pusher\PushNotifications\PushNotifications $beams
     */
    public function __construct(Pusher $pusher, PushNotifications $beams)
    {
        $this->beams = $beams;

        $this->pusher = $pusher;
    }

    /**
     * Sets the log message.
     *
     * @param  string $message
     * @return self
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Sets the log level.
     *
     * @param  string $level
     * @return self
     */
    public function setLevel(string $level): self
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Sets the Pusher channel.
     *
     * @param  string $channel
     * @return self
     */
    public function setChannel(string $channel): self
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * Sets the event name.
     *
     * @param  string $event
     * @return self
     */
    public function setEvent(string $event): self
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Set the interests for Push notifications.
     *
     * @param  array $interests
     * @return self
     */
    public function setInterests(array $interests): self
    {
        $this->interests = $interests;

        return $this;
    }

    /**
     * Quickly log a message.
     *
     * @param string $message
     * @param string $level
     * @return self
     */
    public static function log(string $message, string $level): self
    {
        return app('pusher-logger')
            ->setMessage($message)
            ->setLevel($level);
    }

    /**
     * Dispatch a log message.
     *
     * @return bool
     */
    public function send(): bool
    {
        $this->pusher->trigger($this->channel, $this->event, $this->toPushHttp());

        if ($this->level === static::LEVEL_ERROR) {
            $this->beams->publish($this->interests, $this->toPushBeam());
        }

        return true;
    }

    public function toPushHttp()
    {
        return [
            'title' => 'PusherLogger' . ' ' . ucwords($this->level),
            'message' => $this->message,
            'loglevel' => $this->level,
        ];
    }

    public function toPushBeam()
    {
        return [
            'apns' => [
                'aps' => [
                    'alert' => [
                        'title' => 'PusherLogger' . ' ' . ucwords($this->level),
                        'body' => $this->message,
                        'loglevel' => $this->level
                    ],
                ],
            ],
            'fcm' => [
                'notification' => [
                    'title' => 'PusherLogger' . ' ' . ucwords($this->level),
                    'body' => $this->message,
                    'loglevel' => $this->level
                ],
            ],
        ];
    }
}
