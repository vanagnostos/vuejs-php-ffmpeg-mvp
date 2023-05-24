<?php

declare(strict_types=1);

namespace Ffmpeg\Loader;

class StringDataLoader extends AbstractStringDataLoader
{
    private array $errors = [];

    private bool $correctTimingErrors = true;

    private float $timingErrorsCorrectionValue = 0.001;

    protected function parseData(array $fileData): void
    {
        $patterns = [
            false => self::SILENCE_START,
            true => self::SILENCE_END
        ];

        $pointer = true;

        if ($this->startsWithSilence($fileData[0])) {
            $this->data[] = 0;
            $pointer = false;
        }

        $index = count($this->data);
        foreach ($fileData as $row => $line) {
            if (strpos($line, $patterns[$pointer]) === false) {
                $this->errors[] = sprintf('Row %d: expected %s. Ignored.', $row, $patterns[$pointer]);
                continue;
            }

            $time = (float)explode(':', $line)[1];

            if ($index > 0 && $this->data[$index - 1] >= $time) {
                if (!$this->correctTimingErrors) {
                    $this->errors[] = sprintf(
                        'Row %d: expected time < %f, got %f. Ignored.',
                        $row,
                        $this->data[$index - 1],
                        $time
                    );
                    continue;
                }

                $this->errors[] = sprintf(
                    'Row %d: expected time < %f, got %f. Corrected.',
                    $row,
                    $this->data[$index - 1],
                    $time
                );
                $time = $this->data[$index - 1] + $this->timingErrorsCorrectionValue;
            }

            $this->data[] = $time;
            $pointer = !$pointer;
            $index++;
        }
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function setCorrectTimingErrors(bool $correctTimingErrors): void
    {
        $this->correctTimingErrors = $correctTimingErrors;
    }

    public function setTimingErrorsCorrectionValue(float $timingErrorsCorrectionValue): void
    {
        $this->timingErrorsCorrectionValue = $timingErrorsCorrectionValue;
    }
}
