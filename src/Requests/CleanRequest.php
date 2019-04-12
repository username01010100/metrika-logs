<?php

declare(strict_types=1);

namespace Volga\MetrikaLogs\Requests;

use Volga\MetrikaLogs\Contracts\Request;
use Volga\MetrikaLogs\Requests\Concerns\RequestCore;

/**
 * Class CleanRequest
 *
 * @package Volga\MetrikaLogs\Requests
 */
class CleanRequest extends RequestCore implements Request
{
    protected const METHOD = 'POST';
    protected const ADDRESS = 'https://api-metrika.yandex.net/management/v1/counter/{counterId}/logrequest/{requestId}/clean';

    /**
     * Идентификатор запроса
     *
     * @var null|int
     */
    private static $requestId = null;

    public function __construct(int $counterId, int $requestId)
    {
        parent::__construct($counterId);

        $this->setRequestId($requestId);
    }

    /**
     * Установка запроса
     *
     * @param  int  $requestId
     * @return CleanRequest
     */
    public function setRequestId(int $requestId): CleanRequest
    {
        self::$requestId = $requestId;

        return $this;
    }

    /**
     * Адрес для отправки запроса
     *
     * @return string
     */
    public function getAddress(): string
    {
        return str_replace('{requestId}', self::$requestId, parent::getAddress());
    }
}
