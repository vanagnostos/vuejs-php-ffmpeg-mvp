<?php

declare(strict_types=1);

namespace Ffmpeg;

interface ChannelInterface
{
    public function getLongestMonologueDuration(): float;

    public function getTotalDuration(): float;

    public function getTalkDuration(): float;

    public function getWaveform(): array;
}
