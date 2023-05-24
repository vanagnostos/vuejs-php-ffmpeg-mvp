<?php

declare(strict_types=1);

namespace Ffmpeg;

interface ChannelDataInterface
{
    public function getDataPoints(): array;
}
