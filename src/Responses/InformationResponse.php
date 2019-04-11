<?php

declare(strict_types=1);

namespace Volga\MetrikaLogs\Responses;

use JMS\Serializer\Annotation as JMS;
use Volga\MetrikaLogs\Responses\Concerns\ErrorResponse;
use Volga\MetrikaLogs\Responses\Types\LogRequest;

/**
 * Class InformationResponse
 *
 * @package Volga\MetrikaLogs\Responses
 */
class InformationResponse
{
    use ErrorResponse;

    /**
     * Запрос
     *
     * @JMS\Type("Volga\MetrikaLogs\Responses\Types\LogRequest")
     *
     * @var LogRequest
     */
    protected $log_request;

    /**
     * Запрос
     *
     * @return LogRequest
     */
    public function getLogRequest(): LogRequest
    {
        return $this->log_request;
    }
}
