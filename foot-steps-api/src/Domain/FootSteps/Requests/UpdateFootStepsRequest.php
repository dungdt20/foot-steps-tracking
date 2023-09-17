<?php

declare(strict_types=1);

namespace Domain\FootSteps\Requests;

use Infrastructure\Abstracts\Requests\RequestAbstract;
class UpdateFootStepsRequest extends RequestAbstract
{
    /** @var int */
    private int $userId;

    /** @var string */
    private string $date;

    /** @var int */
    private int $footSteps;

    /**
     * @param int $userId
     * @param string $date
     * @param int $footSteps
     */
    public function __construct(
        int $userId,
        string $date,
        int $footSteps
    ) {
        $this->userId = $userId;
        $this->date = $date;
        $this->footSteps = $footSteps;
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

    /**
     * @return int
     */
    public function getFootSteps(): int
    {
        return $this->footSteps;
    }
}
