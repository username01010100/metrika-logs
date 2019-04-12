<?php

declare(strict_types=1);

namespace Volga\MetrikaLogs\Contracts;

use Psr\Http\Message\ResponseInterface;
use Volga\MetrikaLogs\MetrikaClient;

interface DeserializeResponseInterface
{
    /**
     * Десериализация ответа
     *
     * @param  MetrikaClient  $client
     * @param  ResponseInterface  $response
     * @param  string  $format
     * @return mixed
     */
    public static function deserialize(MetrikaClient $client, ResponseInterface $response, string $format);
}