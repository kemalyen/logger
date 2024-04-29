<?php

namespace Kemalyen\Logger;

use Exception;
use Monolog\Handler\AbstractProcessingHandler;
use Throwable;
use Illuminate\Support\Facades\Log;
use Kemalyen\Logger\Models\LogMessage;
use Monolog\Handler\HandlerInterface;
use Monolog\LogRecord;

class LoggerHandler extends AbstractProcessingHandler  
{
    protected function write(LogRecord $record): void
    {
        $record = is_array($record) ? $record : $record->toArray();

        $exception = $record['context']['exception'] ?? null;

        if ($exception instanceof Throwable) {
            $record['context']['exception'] = (string) $exception;
        }

        try {
            LogMessage::create([
                'level' => $record['level_name'],
                'message' => $record['message'],
                'logged_at' => $record['datetime'],
                'context' => $record['context'],
                'extra' => $record['extra'],
                'channel' => $record['channel'],
            ]);
        } catch (Exception $e) {
            $fallbackChannels = config('logging.channels.fallback.channels', ['single']);

            Log::stack($fallbackChannels)->debug($record['formatted'] ?? $record['message']);

            Log::stack($fallbackChannels)->debug('Could not log to the database.', [
                'exception' => $e,
            ]);
        }
    }

}
