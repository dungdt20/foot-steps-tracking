<?php

namespace Infrastructure\Util\Redis;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

/**
 * Class RedisAbstract
 * @package Infrastructure\Util\Redis
 */
abstract class RedisAbstract
{
    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return Redis::exists($key) === 1;
    }

    /**
     * @param string $key
     * @param $data
     */
    public function setForever(string $key, $data)
    {
        $ttl = 6 * 30 * 24 * 60 * 60; // six month

        $this->setEx($key, $data, $ttl);
    }

    /**
     * @param string $key
     * @return mixed
     */
    abstract public function get(string $key);

    /**
     * @param string $key
     * @param $data
     * @param int $ttl
     */
    abstract public function setEx(string $key, $data, int $ttl): void;

    /**
     * @param string $key
     */
    public function remove(string $key):void
    {
        try {
            Redis::del($key);
        } catch (\RedisClusterException | \RedisException $e) {
            Log::warning($e->getMessage() . PHP_EOL . $e->getTraceAsString());
        }
    }

    /**
     * @param string $key
     * @return int
     */
    public function getRemainTime(string $key): int
    {
        try {
            return (int) Redis::ttl($key);
        } catch (\RedisClusterException | \RedisException $e) {
            Log::warning($e->getMessage() . PHP_EOL . $e->getTraceAsString());
        }

        return 0;
    }
}
