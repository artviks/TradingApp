<?php

namespace Core;

use FastRoute;
use League\Container\Container;

class FastRouter
{
    public static function load(FastRoute\Dispatcher $dispatcher, Container $container): void
    {
        $routeInfo = $dispatcher->dispatch(
            self::requestMethod(),
            self::requestUri()
        );

        switch ($routeInfo[0])
        {
            case FastRoute\Dispatcher::NOT_FOUND:
                // ... 404 Not Found
                break;
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                // ... 405 Method Not Allowed
                break;
            case FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                [$class, $method] = $handler;

                $container->get($class)->$method();

                break;
        }
    }

    private static function requestMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    private static function requestUri(): string
    {
        $uri = $_SERVER['REQUEST_URI'];

        if (false !== $pos = strpos($uri, '?'))
        {
            $uri = substr($uri, 0, $pos);
        }

        return rawurldecode($uri);
    }
}