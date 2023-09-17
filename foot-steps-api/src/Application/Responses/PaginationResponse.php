<?php

declare(strict_types=1);

namespace Application\Responses;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PaginationResponse
{
    /** @var int */
    private int $total;

    /** @var int */
    private int $perPage;

    /** @var int */
    private int $currentPage;

    /** @var array */
    private array $items;

    /**
     * @param LengthAwarePaginator $paginator
     */
    public function __construct(LengthAwarePaginator $paginator)
    {
        $this->total = $paginator->total();
        $this->perPage = $paginator->perPage();
        $this->items = $paginator->items();
        $this->currentPage = $paginator->currentPage();
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @return int
     */
    public function getPerPage(): int
    {
        return $this->perPage;
    }

    /**
     * @return int
     */
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
