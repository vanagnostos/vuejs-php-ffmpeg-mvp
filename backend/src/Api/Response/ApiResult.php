<?php

declare(strict_types=1);

namespace Api\Response;

use JsonSerializable;

class ApiResult implements JsonSerializable
{
    private const STATUS_SUCCESS = 'success';

    private const STATUS_ERROR = 'error';

    private string $status = self::STATUS_ERROR;

    private array $data = [];

    private string $message = '';

    public function setData(array $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function markAsError(): self
    {
        $this->status = self::STATUS_ERROR;
        return $this;
    }

    public function markAsSuccess(): self
    {
        $this->status = self::STATUS_SUCCESS;
        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->data
        ];
    }
}
