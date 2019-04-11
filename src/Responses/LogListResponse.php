<?php

declare(strict_types=1);

namespace Volga\MetrikaLogs\Responses;

use JMS\Serializer\Annotation as JMS;
use Volga\MetrikaLogs\Responses\Concerns\ErrorResponse;

/**
 * Class LogListResponse
 *
 * @package Volga\MetrikaLogs\Responses
 */
class LogListResponse
{
    use ErrorResponse;

    /**
     * Запросы
     *
     * @JMS\Type("array<Volga\MetrikaLogs\Responses\Types\LogRequest>")
     *
     * @var array
     */
    protected $requests = [];

    /**
     * Есть ли запросы?
     *
     * @return bool
     */
    public function hasRequests(): bool
    {
        return !empty($this->requests);
    }

    /**
     * Запросы
     *
     * @return array
     */
    public function getRequests(): array
    {
        return $this->requests;
    }
}
