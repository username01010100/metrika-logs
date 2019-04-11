<?php

declare(strict_types=1);

namespace Volga\MetrikaLogs\Responses;

use JMS\Serializer\Annotation as JMS;
use Volga\MetrikaLogs\Responses\Types\LogRequestEvaluation;

/**
 * Class CapabilityResponse
 *
 * @package Volga\MetrikaLogs\Responses
 */
class CapabilityResponse
{
    /**
     * Оценка возможности создания запросов логов
     *
     * @JMS\Type("Volga\MetrikaLogs\Responses\Types\LogRequestEvaluation")
     *
     * @var LogRequestEvaluation
     */
    protected $log_request_evaluation;

    /**
     * Ошибки
     *
     * @JMS\Type("array<Volga\MetrikaLogs\Responses\Types\Error>")
     *
     * @var array
     */
    protected $errors = [];

    /**
     * HTTP-статус ошибки
     *
     * @JMS\SerializedName("code")
     * @JMS\Type("string")
     *
     * @var null|string
     */
    protected $error_code;

    /**
     * Причина ошибки
     *
     * @JMS\SerializedName("message")
     * @JMS\Type("string")
     *
     * @var null|string
     */
    protected $error_message;

    /**
     * Есть ли ошибки?
     *
     * @return bool
     */
    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    /**
     * Ошибки
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * HTTP-статус ошибки
     *
     * @return null|string
     */
    public function getErrorCode(): ?string
    {
        return $this->error_code;
    }

    /**
     * Причина ошибки
     *
     * @return null|string
     */
    public function getErrorMessage(): ?string
    {
        return $this->error_message;
    }

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
