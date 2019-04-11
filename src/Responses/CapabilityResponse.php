<?php

declare(strict_types=1);

namespace Volga\MetrikaLogs\Responses;

use JMS\Serializer\Annotation as JMS;
use Volga\MetrikaLogs\Responses\Concerns\ErrorResponse;
use Volga\MetrikaLogs\Responses\Types\LogRequestEvaluation;

/**
 * Class CapabilityResponse
 *
 * @package Volga\MetrikaLogs\Responses
 */
class CapabilityResponse
{
    use ErrorResponse;

    /**
     * Оценка возможности создания запросов логов
     *
     * @JMS\Type("Volga\MetrikaLogs\Responses\Types\LogRequestEvaluation")
     *
     * @var LogRequestEvaluation
     */
    protected $log_request_evaluation;

    /**
     * Оценка возможности создания запросов логов
     *
     * @return LogRequestEvaluation
     */
    public function getLogRequestEvaluation(): LogRequestEvaluation
    {
        return $this->log_request_evaluation;
    }
}
