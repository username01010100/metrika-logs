<?php

declare(strict_types=1);

namespace Volga\MetrikaLogs\Contracts;

use Psr\Http\Message\ResponseInterface;

interface OnHeadersRequestInterface
{
    /**
     * Обработчик события 'on_headers'
     *
     * @param  ResponseInterface  $response
     */
    public static function onHeadersHandler(ResponseInterface $response): void;
}