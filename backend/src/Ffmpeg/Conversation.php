<?php

declare(strict_types=1);

namespace Ffmpeg;

class Conversation
{
    private ChannelInterface $userChannel;

    private ChannelInterface $customerChannel;

    public function __construct(ChannelInterface $userChannel, ChannelInterface $customerChannel)
    {
        $this->userChannel = $userChannel;
        $this->customerChannel = $customerChannel;
    }

    public function getTotalDuration(): float
    {
        return max($this->userChannel->getTotalDuration(), $this->customerChannel->getTotalDuration());
    }

    public function getLongestUserMonologueDuration(): float
    {
        return $this->userChannel->getLongestMonologueDuration();
    }

    public function getLongestCustomerMonologueDuration(): float
    {
        return $this->customerChannel->getLongestMonologueDuration();
    }

    public function getUserTalkPercentage(): float
    {
        if (!$this->getTotalDuration()) {
            return 0;
        }

        return 100 * $this->userChannel->getTalkDuration() / $this->getTotalDuration();
    }

    public function getUserWaveform(): array
    {
        return $this->userChannel->getWaveform();
    }

    public function getCustomerWaveform(): array
    {
        return $this->customerChannel->getWaveform();
    }
}
