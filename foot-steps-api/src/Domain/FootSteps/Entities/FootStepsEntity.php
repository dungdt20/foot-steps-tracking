<?php

declare(strict_types=1);

namespace Domain\FootSteps\Entities;

use Illuminate\Support\Facades\Date;
use Infrastructure\Abstracts\Entities\EntityAbstract;

/**
 * Class FootStepsEntity
 * @package Domain\FootSteps\Entities
 */
class FootStepsEntity extends EntityAbstract
{
    /**
     * @var int
     */
    public int $userId;

    /**
     * @var int
     */
    public int $steps;

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getSteps(): int
    {
        return $this->steps;
    }

    /**
     * @param int $steps
     */
    public function setSteps(int $steps): void
    {
        $this->steps = $steps;
    }
}
