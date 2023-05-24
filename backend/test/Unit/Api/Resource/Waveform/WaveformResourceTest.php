<?php

declare(strict_types=1);

namespace UnitTest\Api\Resource\Waveform;

use Api\Request\Request;
use Api\Resource\Waveform\WaveformResource;
use Api\Response\ApiResult;
use Ffmpeg\Conversation;
use PHPUnit\Framework\TestCase;

class WaveformResourceTest extends TestCase
{
    public function testRunReturnsResponse(): void
    {
        $conversation = $this->getMockBuilder(Conversation::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'getLongestUserMonologueDuration',
                'getLongestCustomerMonologueDuration',
                'getUserTalkPercentage',
                'getUserWaveform',
                'getCustomerWaveform'
            ])
            ->getMock();

        $longestUserMonologueDuration = 20.1;
        $conversation->expects($this->exactly(1))
            ->method('getLongestUserMonologueDuration')
            ->willReturn($longestUserMonologueDuration);

        $longestCustomerMonologueDuration = 30.2;
        $conversation->expects($this->exactly(1))
            ->method('getLongestCustomerMonologueDuration')
            ->willReturn($longestCustomerMonologueDuration);

        $userTalkPercentage = 10.3;
        $conversation->expects($this->exactly(1))
            ->method('getUserTalkPercentage')
            ->willReturn($userTalkPercentage);

        $userWaveform = [[1, 2], [3, 4], [5, 6]];
        $conversation->expects($this->exactly(1))
            ->method('getUserWaveform')
            ->willReturn($userWaveform);

        $customerWaveform = [[1.1, 2], [3.2, 4.3], [5, 6.7]];
        $conversation->expects($this->exactly(1))
            ->method('getCustomerWaveform')
            ->willReturn($customerWaveform);

        $resource = new WaveformResource($conversation, new Request([]), []);

        $result = $resource->run();

        $this->assertInstanceOf(ApiResult::class, $result);

        $this->assertEquals(
            [
                'status' => 'success',
                'message' => '',
                'data' => [
                    'longest_user_monologue' => $longestUserMonologueDuration,
                    'longest_customer_monologue' => $longestCustomerMonologueDuration,
                    'user_talk_percentage' => $userTalkPercentage,
                    'user' => $userWaveform,
                    'customer' => $customerWaveform
                ]
            ],
            $result->jsonSerialize()
        );
    }
}
