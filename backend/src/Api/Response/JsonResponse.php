<?php

declare(strict_types=1);

namespace Api\Response;

class JsonResponse extends AbstractResponse
{
    protected array $headers = [
        'Access-Control-Allow-Origin: *',
        'Content-type: application/json; charset=utf-8'
    ];

    public function getBody(): string
    {
        return json_encode($this->body) ?: '';
    }
}
