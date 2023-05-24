<?php

declare(strict_types=1);

namespace UnitTest\Ffmpeg\Loader;

use Ffmpeg\Channel;
use Ffmpeg\Loader\SimpleStringDataLoader;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ChannelTest extends TestCase
{
    public function testGetTotalDurationReturnsZero(): void
    {
        $data = $this->getDataMock([]);

        $channel = new Channel($data);

        $this->assertEquals(0, $channel->getTotalDuration());
    }

    public function testGetTotalDurationReturnsValue(): void
    {
        $data = $this->getDataMock([0, 2.2, 4.1, 6, 8, 10.3]);

        $channel = new Channel($data);

        $this->assertEquals(10.3, $channel->getTotalDuration());
    }

    public function testGetLongestMonologueDurationReturnsValue(): void
    {
        $data = $this->getDataMock([0, 2.2, 4, 18, 19, 20.3]);

        $channel = new Channel($data);

        $this->assertEquals(14, $channel->getLongestMonologueDuration());
    }

    public function testGetWaveformReturnsEmpty(): void
    {
        $data = $this->getDataMock([]);

        $channel = new Channel($data);

        $this->assertEquals([], $channel->getWaveform());
    }

    public function testGetWaveformReturnsValues(): void
    {
        $data = $this->getDataMock([0, 2.2, 4.1, 6, 8, 10.3]);

        $channel = new Channel($data);

        $this->assertEquals([[0, 2.2], [4.1, 6], [8, 10.3]], $channel->getWaveform());
    }

    public function testGetTalkDurationReturnsValue(): void
    {
        $data = $this->getDataMock([0, 2.2, 4, 18, 19, 20.3]);

        $channel = new Channel($data);

        $this->assertEquals(17.5, $channel->getTalkDuration());
    }

    /**
     * @param array $returnValue
     * @return MockObject&SimpleStringDataLoader
     */
    private function getDataMock(array $returnValue): MockObject
    {
        $data = $this->getMockBuilder(SimpleStringDataLoader::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getDataPoints'])
            ->getMock();

        $data->expects($this->exactly(1))
            ->method('getDataPoints')
            ->willReturn($returnValue);

        return $data;
    }
}
