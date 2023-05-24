<?php

return [
    'mode' => getenv('APPLICATION_ENV') == Api\Application::MODE_PRODUCTION ?
        Api\Application::MODE_PRODUCTION : Api\Application::MODE_DEVELOPMENT,
    'routes' => [
        Api\Request\RequestMethod::GET => [
            'waveform' => Api\Resource\Waveform\WaveformResource::class,
        ]
    ],
    'factories' => [
        Api\Resource\Waveform\WaveformResource::class =>
            Api\Resource\Waveform\WaveformResourceFactory::class
    ],
    'dataPath' => 'data'
];
