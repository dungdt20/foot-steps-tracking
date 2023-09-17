<?php

declare(strict_types=1);

namespace Infrastructure\Abstracts\Responses;

/**
 * Abstract ResponseAbstract
 * @package Infrastructure\Abstracts\Responses
 */
abstract class ResponseAbstract
{
    /**
     * @var
     */
    public $data;

    /**
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function data()
    {
        return $this->data;
    }
}
