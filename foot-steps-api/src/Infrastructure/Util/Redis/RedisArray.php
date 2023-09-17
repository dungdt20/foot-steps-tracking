<?php

namespace Infrastructure\Util\Redis;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

/**
 * Class RedisArray
 * @package Infrastructure\Util\Redis
 */
class RedisArray extends RedisAbstract
{
    /**
     * @inheritDoc
     */
    public function get(string $key): ?array
    {
        try {
            $jsonString = Redis::get($key) ?? '';
            $jsonArray = json_decode($jsonString, true);

            return is_array($jsonArray) ? $jsonArray : null;
        } catch (\RedisClusterException | \RedisException $e) {
            Log::warning($e->getMessage() . PHP_EOL . $e->getTraceAsString());
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function setEx(string $key, $data, int $ttl): void
    {
        if (!is_array($data)) {
            return;
        }

        try {
            Redis::setEx($key, $ttl, json_encode($data));
        } catch (\RedisClusterException | \RedisException $e) {
            Log::warning($e->getMessage() . PHP_EOL . $e->getTraceAsString());
        }
    }
}
