<?php

namespace Ymigval\LaravelSLResponse\Exceptions;

use Exception;

class SLException extends Exception
{
    /**
     * @var int
     */
    protected int $status = 422;

    /**
     * @param mixed|null $message
     */
    public function __construct(mixed $message = null)
    {
        parent::__construct($message);
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->status;
    }
}
