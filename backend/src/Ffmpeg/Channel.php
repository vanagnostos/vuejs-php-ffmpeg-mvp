<?php

declare(strict_types=1);

namespace Ffmpeg;

class Channel implements ChannelInterface
{
    private array $waveform = [];

    private float $longestMonologueDuration = 0;

    private float $talkDuration = 0;

    public function __construct(ChannelDataInterface $dataSource)
    {
        $dataPoints = $dataSource->getDataPoints();
        $dataPointsCount = count($dataPoints);

        for ($i = 0; $i < $dataPointsCount; $i += 2) {
            if (!isset($dataPoints[$i + 1])) {
                break;
            }

            $part = [$dataPoints[$i], $dataPoints[$i + 1]];

            $duration = $part[1] - $part[0];

            $this->talkDuration += $duration;

            if ($this->longestMonologueDuration < $duration) {
                $this->longestMonologueDuration = $duration;
            }

            $this->waveform[] = $part;
        }
    }

    public function getLongestMonologueDuration(): float
    {
        return $this->longestMonologueDuration;
    }

    public function getTotalDuration(): float
    {
        if (!$this->waveform) {
            return 0;
        }

        return $this->waveform[count($this->waveform) - 1][1];
    }

    public function getWaveform(): array
    {
        return $this->waveform;
    }

    public function getTalkDuration(): float
    {
        return $this->talkDuration;
    }
}
