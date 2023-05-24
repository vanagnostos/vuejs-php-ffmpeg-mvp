<?php

declare(strict_types=1);

namespace UnitTest\Ffmpeg\Loader;

use InvalidArgumentException;

trait StringDataLoaderTestTrait
{
    public function testLoaderThrowsExceptionIfFileIsEmpty(): void
    {
        $loader = $this->getLoader();

        $this->expectException(InvalidArgumentException::class);

        $loader->loadFromFile(__DIR__ . '/../assets/empty-file.txt');
    }

    public function testLoaderThrowsExceptionIfFileIsNotValid(): void
    {
        $loader = $this->getLoader();

        $this->expectException(InvalidArgumentException::class);

        $loader->loadFromFile(__DIR__ . '/../assets/invalid-file.txt');
    }

    public function testLoaderLoadsData(): void
    {
        $loader = $this->getLoader();

        $loader->loadFromFile(__DIR__ . '/../assets/valid-file.txt');

        $this->assertSame($loader->getDataPoints(), [
            4.48,
            26.928,
            29.184,
            29.36,
            31.744
        ]);
    }

    public function testLoaderInvertsData(): void
    {
        $loader = $this->getLoader();

        $loader->loadFromFile(__DIR__ . '/../assets/valid-file-invert.txt');

        $this->assertSame($loader->getDataPoints(), [
            0,
            1.84,
            4.48,
            26.928,
            29.184,
            29.36,
            31.744
        ]);
    }
}
