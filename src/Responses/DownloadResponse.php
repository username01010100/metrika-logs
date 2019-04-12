<?php

declare(strict_types=1);

namespace Volga\MetrikaLogs\Responses;

use Psr\Http\Message\ResponseInterface;
use Volga\MetrikaLogs\Contracts\DeserializeResponseInterface;
use Volga\MetrikaLogs\MetrikaClient;
use Volga\MetrikaLogs\Responses\Concerns\ErrorResponse;

/**
 * Class DownloadResponse
 *
 * @package Volga\MetrikaLogs\Responses
 */
class DownloadResponse implements DeserializeResponseInterface
{
    use ErrorResponse;

    /**
     * Десериализация ответа
     *
     * @param  MetrikaClient  $client
     * @param  ResponseInterface  $response
     * @param  string  $format
     * @return array|mixed|object|\Psr\Http\Message\StreamInterface
     */
    public static function deserialize(MetrikaClient $client, ResponseInterface $response, string $format)
    {
        if (200 === $response->getStatusCode()) {
            return $response->getBody();
        }

        return $client->getSerializer()->deserialize($response->getBody()->getContents(), self::class, $format);
    }
}
