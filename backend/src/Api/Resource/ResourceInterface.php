<?php

declare(strict_types=1);

namespace Api\Resource;

use JsonSerializable;

interface ResourceInterface
{
    public function run(): JsonSerializable;
}
