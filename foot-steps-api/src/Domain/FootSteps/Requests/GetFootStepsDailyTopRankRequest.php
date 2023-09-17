<?php

declare(strict_types=1);

namespace Domain\FootSteps\Requests;

use Infrastructure\Abstracts\Requests\RequestAbstract;

class GetFootStepsDailyTopRankRequest extends RequestAbstract
{
    /** @var string */
    private string $date;

    /** @var int */
    private int $limit;

    /**
     * @param string $date
     * @param int $limit
     */
    public function __construct(
        string $date,
        int $limit = 5
    )
    {
        $this->date = $date;
        $this->limit = $limit;
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
    public function getLimit(): int
    {
        return $this->limit;
    }
}
