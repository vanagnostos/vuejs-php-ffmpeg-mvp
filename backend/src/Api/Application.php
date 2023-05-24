<?php

declare(strict_types=1);

namespace Api;

use Api\Exceptions\RouteError;
use Api\Resource\ResourceFactoryInterface;
use Api\Response\ApiResult;
use Api\Response\HtmlResponse;
use Api\Response\JsonResponse;
use Api\Response\ResponseCode;
use Api\Response\ResponseInterface;
use Throwable;

class Application
{
    public const MODE_PRODUCTION = 'production';
    public const MODE_DEVELOPMENT = 'development';

    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function run(): void
    {
        try {
            $resource = '';
            $method = $_SERVER['REQUEST_METHOD'];

            $urlParts = explode('/', trim($_SERVER['PHP_SELF'], '/'));
            foreach (array_reverse($urlParts) as $part) {
                if (isset($this->config['routes'][$method][$part])) {
                    $resource = $this->config['routes'][$method][$part] ?? '';
                    break;
                }
            }

            if (!$resource) {
                throw new RouteError(sprintf('Unknown route "%s"', $_SERVER['PHP_SELF']));
            }

            $factory = $this->config['factories'][$resource] ?? '';

            if (!is_subclass_of($factory, ResourceFactoryInterface::class)) {
                throw new RouteError(sprintf('Invalid resource "%s"', $resource));
            }

            $code = ResponseCode::OK;
            $response = $factory::create($urlParts, $this->config)->run();
        } catch (Throwable $t) {
            // TODO error log ...
            $message = $this->config['mode'] == Application::MODE_PRODUCTION ?
                'Application error, please try again.' : $t->getMessage();
            $code = $t instanceof RouteError ? ResponseCode::NOT_FOUND : ResponseCode::SERVER_ERROR;
            $response = (new ApiResult())->setMessage($message);
        }

        // this could use a strategy...
        $this->renderResponse(
            stripos($_SERVER['HTTP_ACCEPT'], 'text/html') === 0 ?
                new HtmlResponse($code, $response) :
                new JsonResponse($code, $response)
        );
    }

    private function renderResponse(ResponseInterface $response): void
    {
        http_response_code($response->getStatusCode());

        foreach ($response->getHeaders() as $header) {
            header($header);
        }

        echo $response->getBody();
    }
}
