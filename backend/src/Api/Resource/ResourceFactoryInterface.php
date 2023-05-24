<?php

declare(strict_types=1);

namespace Api\Resource;

interface ResourceFactoryInterface
{
    public static function create(array $routeMatch, array $config): ResourceInterface;
}
