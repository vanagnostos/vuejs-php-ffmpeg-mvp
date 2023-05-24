<?php

declare(strict_types=1);

namespace Api\Response;

interface ResponseInterface
{
    public function getHeaders(): array;

    public function getBody(): string;

    public function getStatusCode(): int;
}
