<?php

declare(strict_types=1);

namespace Domain\FootSteps\Requests;

use Infrastructure\Abstracts\Requests\RequestAbstract;

class GetFootStepsWeeklyRequest extends RequestAbstract
{
    /** @var int */
    private int $userId;

    /** @var string */
    private string $date;

    /**
     * @param int $userId
     * @param string $date
     */
    public function __construct(int $userId, string $date)
    {
        $this->userId = $userId;
        $this->date = $date;
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
    public function getDate(): string
    {
        return $this->date;
    }
}
