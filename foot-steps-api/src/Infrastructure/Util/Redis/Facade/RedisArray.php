<?php

namespace Infrastructure\Util\Redis\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * Class RedisArray
 * @package Infrastructure\Util\Redis\Facade
 *
 * @method static void remove(string $key)
 * @method static array setForever(string $key, array $data)
 * @method static array|null get(string $key)
 * @method static bool has(string $key)
 * @method static void setEx(string $key, array $data, int $ttl)
 * @method static int getRemainTime(string $key)
 *
 * @see \Infrastructure\Util\Redis\RedisArray
 */
class RedisArray extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Infrastructure\Util\Redis\RedisArray::class;
    }
}
