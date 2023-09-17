<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class SecureHeaders
 * @package App\Http\Middleware
 */
class SecureHeaders
{
    /**
     * @var array
     */
    private $unwantedHeaderList = [
        'X-Powered-By',
        'Server',
    ];

    /**
     * @var array
     */
    private $securedHeaderList = [
        'Referrer-Policy' => 'no-referrer-when-downgrade',
        'X-XSS-Protection' => '1; mode=block',
        'X-Frame-Options' => 'sameorigin',
        'X-Content-Type-Options' => 'nosniff',
        'Cache-Control' => 'no-cache, no-store, max-age=0, must-revalidate'
    ];

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $this->removeUnwantedHeaders($response);
        $this->addSecuredHeaders($request, $response);

        return $response;
    }

    /**
     * @param Response $response
     */
    private function removeUnwantedHeaders($response)
    {
        foreach ($this->unwantedHeaderList as $header) {
            if ($response->headers->has($header)) {
                $response->headers->remove($header);
            }
        }
    }

    /**
     * @param Request $request
     * @param Response $response
     */
    private function addSecuredHeaders($request, $response)
    {
        foreach ($this->securedHeaderList as $header => $value) {
            $response->headers->set($header, $value);
        }

        if ($request->getRequestUri() === '/api/documentation') {
            $response->headers->set('Content-Security-Policy', "default-src 'self' *.com; object-src 'none'; "
                . "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com http://www.w3.org; "
                . "style-src-elem 'self' 'unsafe-inline' https://fonts.googleapis.com; "
                . "font-src 'self' https://fonts.gstatic.com; "
                . "script-src 'self' 'unsafe-inline'; "
                . "img-src * data:; "
                . "frame-ancestors 'none'; "
                . "form-action *.com"
            );
        } else {
            $response->headers->set('Content-Security-Policy', "default-src 'none'; "
                . "frame-ancestors 'none'; "
                . "form-action 'none'"
            );
        }
    }
}
