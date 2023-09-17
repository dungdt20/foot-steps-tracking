<?php

if (! function_exists('parse_redis_host_info')) {

    /**
     * @param $hostInfo
     * @return array
     */
    function parse_redis_host_info($hostInfo)
    {
        $hostInfoArray = explode(':', $hostInfo, 2);
        if (count($hostInfoArray) === 2) {
            list($host, $port) = $hostInfoArray;
        } else {
            $host = $hostInfoArray[0];
            $port = (! empty(env('REDIS_PORT')) ? env('REDIS_PORT') : 6379);
        }

        return [$host, $port];
    }
}

if (! function_exists('get_redis_cluster_seed_array_from_env')) {
    /**
     * @return array
     */
    function get_redis_cluster_seed_array_from_env()
    {
        if (empty(env('REDIS_HOST'))) {
            return [];
        }
        $redisHosts = explode(',', env('REDIS_HOST'));
        shuffle($redisHosts);
        $clusterSeedArray = [];
        foreach ($redisHosts as $hostInfo) {
            list($host, $port) = parse_redis_host_info($hostInfo);

            try {
                $fp = fsockopen($host, $port, $errno, $errstr, 0.1);
                if ($fp) {
                    fclose($fp);
                    $cluster = ['host' => $host, 'port' => $port];
                    array_push($clusterSeedArray, $cluster);
                    break;
                }
            } catch (\Throwable $exception) {
            }
        }

        if (!$clusterSeedArray && $redisHosts) {
            $hostInfo = $redisHosts[0];
            list($host, $port) = parse_redis_host_info($hostInfo);
            array_push($clusterSeedArray, ['host' => $host, 'port' => $port]);
        }

        return $clusterSeedArray;
    }
}

if (!function_exists('get_mysql_host_from_env')) {
    /**
     * @return string
     */
    function get_mysql_host_from_env()
    {
        $mysqlHostArray = explode(',', env('DB_HOST'));
        foreach ($mysqlHostArray as $mysqlHost) {
            $conn = @mysqli_connect(
                $mysqlHost,
                env('DB_USERNAME'),
                env('DB_PASSWORD'),
                env('DB_DATABASE'),
                env('DB_PORT', 3306)
            );
            //Break out with first success connection
            if ($conn) {
                $conn->close();
                return (string)$mysqlHost;
            }
        }

        return '127.0.0.1';
    }
}
