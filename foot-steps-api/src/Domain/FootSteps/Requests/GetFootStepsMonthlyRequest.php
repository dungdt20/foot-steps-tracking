<?php

declare(strict_types=1);

namespace Domain\FootSteps\Requests;

use Infrastructure\Abstracts\Requests\RequestAbstract;

class GetFootStepsMonthlyRequest extends RequestAbstract
{
    /** @var int */
    private int $userId;

    /** @var string */
    private string $month;

    /**
     * @param int $userId
     * @param string $month
     */
    public function __construct(int $userId, string $month)
    {
        $this->userId = $userId;
        $this->month = $month;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getMonth(): string
    {
        return $this->month;
    }
}
