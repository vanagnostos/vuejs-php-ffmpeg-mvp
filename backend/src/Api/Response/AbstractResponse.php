<?php

declare(strict_types=1);

namespace Api\Response;

use JsonSerializable;

abstract class AbstractResponse implements ResponseInterface
{
    protected JsonSerializable $body;

    protected array $headers = [];

    private int $statusCode;

    public function __construct(int $statusCode, JsonSerializable $body)
    {
        $this->statusCode = $statusCode;
        $this->body = $body;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }
}
