<?php

namespace Neo\PusherLogger;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

class PusherLoggerHandler extends AbstractProcessingHandler
{
    /**
     * {@inheritdoc}
     */
    protected function write(array $record): void
    {
        $level = strtolower(Logger::getLevelName($record['level']));

        PusherLogger::log($record['message'], $level)
            ->setEvent('log-event')
            ->setChannel('log-channel')
            ->setInterests(['log-interest'])
            ->send();
    }
}
