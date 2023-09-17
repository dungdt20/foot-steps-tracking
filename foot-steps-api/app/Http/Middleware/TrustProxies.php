<?php

namespace App\Http\Middleware;

use Fideloper\Proxy\TrustProxies as Middleware;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * @var array|string|null
     */
    protected $proxies;

    /**
     * The headers that should be used to detect proxies.
     *
     * @var int
     */
    protected $headers = Request::HEADER_X_FORWARDED_FOR |
                    Request::HEADER_X_FORWARDED_HOST |
                    Request::HEADER_X_FORWARDED_PORT |
                    Request::HEADER_X_FORWARDED_PROTO |
                    Request::HEADER_X_FORWARDED_AWS_ELB;

    /**
     * TrustProxies constructor.
     * @param Repository $config
     */
    public function __construct(Repository $config)
    {
        parent::__construct($config);
        $this->proxies = $this->getProxies();
    }

    /**
     * @return string|string[]
     */
    private function getProxies()
    {
        $proxyConfig = config('proxy.trusted_proxy');

        if ($proxyConfig === '*' | empty($proxyConfig)) {
            return '*';
        }

        return explode(',', $proxyConfig);
    }
}
