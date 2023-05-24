<?php

declare(strict_types=1);

namespace Api\Resource\Waveform;

use Api\Exceptions\ApiProblem;
use Api\Request\Request;
use Api\Resource\ResourceFactoryInterface;
use Api\Resource\ResourceInterface;
use Api\Response\ResponseCode;
use Ffmpeg\Channel;
use Ffmpeg\Conversation;
use Ffmpeg\Loader\PhpArrayDataLoader;

class WaveformResourceFactory implements ResourceFactoryInterface
{
    public static function create(array $routeMatch, array $config): ResourceInterface
    {
        if (!$routeMatch || !is_numeric($routeMatch[count($routeMatch) - 1])) {
            throw new ApiProblem('The GET method has not been defined for collections', ResponseCode::NOT_ALLOWED);
        }

        $id = $routeMatch[count($routeMatch) - 1];
        $userFile = $config['parsedDataPath'] . '/' . $id . '/user-channel.txt';
        $customerFile = $config['parsedDataPath'] . '/' . $id . '/customer-channel.txt';

        if (!file_exists($customerFile) || !file_exists($userFile)) {
            throw new ApiProblem(sprintf('Invalid conversation ID "%d"', $id), ResponseCode::NOT_FOUND);
        }

        /* Consume raw files directly (also change to rawDataPath above)
        $userChannel = new Channel((new StringDataLoader())->loadFromFile($userFile));
        $customerChannel = new Channel((new StringDataLoader())->loadFromFile($customerFile));
        */

        $userChannel = new Channel((new PhpArrayDataLoader())->loadFromFile($userFile));
        $customerChannel = new Channel((new PhpArrayDataLoader())->loadFromFile($customerFile));

        return new WaveformResource(
            new Conversation($userChannel, $customerChannel),
            new Request([
                'id' => $id
            ]),
            $config
        );
    }
}
