<?php

declare(strict_types=1);

namespace Api\Response;

abstract class ResponseCode
{
    public const OK = 200;
    public const NOT_FOUND = 404;
    public const NOT_ALLOWED = 405;
    public const SERVER_ERROR = 500;
}
