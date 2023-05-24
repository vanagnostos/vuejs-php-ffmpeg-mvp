<?php

declare(strict_types=1);

namespace UnitTest\Ffmpeg\Loader;

use Ffmpeg\Loader\SimpleStringDataLoader;
use PHPUnit\Framework\TestCase;

class SimpleStringDataLoaderTest extends TestCase
{
    use StringDataLoaderTestTrait;

    protected function getLoader(): SimpleStringDataLoader
    {
        return new SimpleStringDataLoader();
    }
}
