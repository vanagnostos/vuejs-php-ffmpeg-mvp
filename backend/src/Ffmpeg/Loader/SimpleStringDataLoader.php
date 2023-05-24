<?php

declare(strict_types=1);

namespace Ffmpeg\Loader;

class SimpleStringDataLoader extends AbstractStringDataLoader
{
    protected function parseData(array $fileData): void
    {
        if ($this->startsWithSilence($fileData[0])) {
            $this->data[] = 0;
        }

        foreach ($fileData as $line) {
            $this->data[] = (float)explode(':', $line)[1];
        }
    }
}
