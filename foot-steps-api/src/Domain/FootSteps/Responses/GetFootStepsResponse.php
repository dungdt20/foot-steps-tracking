<?php

declare(strict_types=1);

namespace Domain\FootSteps\Responses;

use Infrastructure\Abstracts\Responses\ResponseAbstract;

/**
 * Class GetFootStepsResponse
 * @package Domain\FootSteps\Responses
 */
class GetFootStepsResponse extends ResponseAbstract
{
    /**
     * @return array|array[]
     */
    public function data(): array
    {
        return $this->data;
    }
}
