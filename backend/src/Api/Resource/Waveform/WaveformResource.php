<?php

declare(strict_types=1);

namespace Api\Resource\Waveform;

use Api\Request\Request;
use Api\Resource\AbstractResource;
use Ffmpeg\Conversation;
use JsonSerializable;

class WaveformResource extends AbstractResource
{
    private Conversation $conversation;

    public function __construct(Conversation $conversation, Request $request, array $config)
    {
        parent::__construct($request, $config);
        $this->conversation = $conversation;
    }

    public function run(): JsonSerializable
    {
        return $this->getSuccessResult([
            'longest_user_monologue' => $this->conversation->getLongestUserMonologueDuration(),
            'longest_customer_monologue' => $this->conversation->getLongestCustomerMonologueDuration(),
            'user_talk_percentage' => $this->conversation->getUserTalkPercentage(),
            'user' => $this->conversation->getUserWaveform(),
            'customer' => $this->conversation->getCustomerWaveform()
        ]);
    }
}
