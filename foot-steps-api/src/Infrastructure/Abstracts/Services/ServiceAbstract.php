<?php

declare(strict_types=1);

namespace Infrastructure\Abstracts\Services;

use Infrastructure\Abstracts\Requests\RequestAbstract;
use Infrastructure\Abstracts\Responses\ResponseAbstract;

/**
 * Abstract ServiceAbstract
 * @package Infrastructure\Services
 *
 */
abstract class ServiceAbstract
{
    /**
     * @param RequestAbstract|null $request
     * @return ResponseAbstract
     */
    abstract function execute(RequestAbstract $request = null): ResponseAbstract;
}
