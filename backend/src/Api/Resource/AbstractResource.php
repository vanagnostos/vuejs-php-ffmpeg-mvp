<?php

declare(strict_types=1);

namespace Api\Resource;

use Api\Request\Request;
use Api\Response\ApiResult;

abstract class AbstractResource implements ResourceInterface
{
    private array $config;

    private Request $request;

    public function __construct(Request $request, array $config)
    {
        $this->config = $config;
        $this->request = $request;
    }

    protected function getConfig(): array
    {
        return $this->config;
    }

    protected function getRequest(): Request
    {
        return $this->request;
    }

    protected function getSuccessResult(array $data): ApiResult
    {
        return (new ApiResult())->setData($data)->markAsSuccess();
    }

    protected function getErrorResult(string $message): ApiResult
    {
        return (new ApiResult())->setMessage($message);
    }
}
