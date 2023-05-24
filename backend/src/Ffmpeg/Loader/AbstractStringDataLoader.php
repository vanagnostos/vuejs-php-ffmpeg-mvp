<?php

declare(strict_types=1);

namespace Ffmpeg\Loader;

use Ffmpeg\ChannelDataInterface;
use InvalidArgumentException;

abstract class AbstractStringDataLoader implements ChannelDataInterface
{
    protected const SILENCE_START = 'silence_start';
    protected const SILENCE_END = 'silence_end';

    protected array $data = [];

    abstract protected function parseData(array $fileData): void;

    public function loadFromFile(string $filePath): self
    {
        $fileData = array_filter(file($filePath) ?: []);

        if (!$fileData) {
            throw new InvalidArgumentException(sprintf('"%s" is empty', $filePath));
        }

        $this->parseData($fileData);

        if (!$this->data) {
            throw new InvalidArgumentException(sprintf('Unable to parse "%s"', $filePath));
        }

        return $this;
    }

    public function getDataPoints(): array
    {
        return $this->data;
    }

    protected function startsWithSilence(string $line): bool
    {
        $startsWithSilence = strpos($line, self::SILENCE_START) !== false;
        $startsWithSpeech = strpos($line, self::SILENCE_END) !== false;

        if (!$startsWithSilence && !$startsWithSpeech) {
            throw new InvalidArgumentException('Invalid data, expected silence_(start|end)');
        }

        return $startsWithSilence;
    }
}
