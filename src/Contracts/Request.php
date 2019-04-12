<?php

declare(strict_types=1);

namespace Volga\MetrikaLogs\Contracts;

/**
 * Interface Request
 *
 * @package Volga\MetrikaLogs\Contracts
 */
interface Request
{
    /**
     * Адрес для отправки запроса
     *
     * @return string
     */
    public function getAddress(): string;

    /**
     * Метод отправки запроса
     *
     * @return string
     */
    public function getMethod(): string;
}
