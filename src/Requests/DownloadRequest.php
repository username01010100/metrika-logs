<?php

declare(strict_types=1);

namespace Volga\MetrikaLogs\Requests;

use Volga\MetrikaLogs\Contracts\Request;
use Volga\MetrikaLogs\Requests\Concerns\RequestCore;

/**
 * Class DownloadRequest
 *
 * @package Volga\MetrikaLogs\Requests
 */
class DownloadRequest extends RequestCore implements Request
{
    protected const METHOD = 'GET';
    protected const ADDRESS = 'https://api-metrika.yandex.net/management/v1/counter/{counterId}/logrequest/{requestId}/part/{partNumber}/download';

    /**
     * Идентификатор запроса
     *
     * @var null|int
     */
    private static $requestId = null;

    /**
     * Номер части подготовленных логов обработанного запроса
     *
     * @var null|int
     */
    private static $partNumber = null;

    public function __construct(int $counterId, int $requestId, int $partNumber)
    {
        parent::__construct($counterId);

        $this
            ->setRequestId($requestId)
            ->setPartNumber($partNumber);
    }

    /**
     * Установка запроса
     *
     * @param  int  $requestId
     * @return DownloadRequest
     */
    public function setRequestId(int $requestId): DownloadRequest
    {
        self::$requestId = $requestId;

        return $this;
    }

    /**
     * Установка номера части подготовленных логов обработанного запроса
     *
     * @param  int  $partNumber
     * @return DownloadRequest
     */
    public function setPartNumber(int $partNumber): DownloadRequest
    {
        self::$partNumber = $partNumber;

        return $this;
    }

    /**
     * Адрес для отправки запроса
     *
     * @return string
     */
    public function getAddress(): string
    {
        return str_replace(
            '{partNumber}',
            self::$partNumber,
            str_replace(
                '{requestId}',
                self::$requestId,
                parent::getAddress()
            )
        );
    }
}
