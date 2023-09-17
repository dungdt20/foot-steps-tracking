<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustHosts as Middleware;

class TrustHosts extends Middleware
{
    /**
     * Get the host patterns that should be trusted.
     *
     * @return array
     */
    public function hosts()
    {
        return [
            $this->allSubdomainsOfApplicationUrl(),
        ];
    }

    /**
     * Get a regular expression matching the application URL and all of its subdomains.
     *
     * @return string|null
     */
    protected function allSubdomainsOfApplicationUrl()
    {
        $host = parse_url($this->app['config']->get('app.url'), PHP_URL_HOST);
        $pattern = empty(env('TRUSTED_HOST', ''))
                ? $host : env('TRUSTED_HOST');

        return '^(.+\.)?'.preg_quote($pattern).'$';
    }
}
