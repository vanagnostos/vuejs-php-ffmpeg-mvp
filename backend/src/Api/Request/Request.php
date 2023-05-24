<?php

declare(strict_types=1);

namespace Api\Request;

class Request
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getIdentifier(): string
    {
        return (string)($this->data['id'] ?? '');
    }
}
