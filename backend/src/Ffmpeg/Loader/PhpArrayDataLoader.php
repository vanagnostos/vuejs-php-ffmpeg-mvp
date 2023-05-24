<?php

declare(strict_types=1);

namespace Ffmpeg\Loader;

use Ffmpeg\ChannelDataInterface;

class PhpArrayDataLoader implements ChannelDataInterface
{
    protected array $data = [];

    public function loadFromFile(string $filePath): self
    {
        $this->data = require $filePath;

        return $this;
    }

    public function getDataPoints(): array
    {
        return $this->data;
    }
}
