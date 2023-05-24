<?php

declare(strict_types=1);

namespace UnitTest\Ffmpeg\Loader;

use Ffmpeg\Loader\StringDataLoader;
use PHPUnit\Framework\TestCase;

class StringDataLoaderTest extends TestCase
{
    use StringDataLoaderTestTrait;

    protected function getLoader(): StringDataLoader
    {
        return new StringDataLoader();
    }
}
