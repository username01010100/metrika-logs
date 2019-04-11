<?php

declare(strict_types=1);

namespace Volga\MetrikaLogs\Requests;

use Volga\MetrikaLogs\Contracts\Request;
use Volga\MetrikaLogs\Requests\Concerns\RequestCore;

/**
 * Class LogListRequest
 *
 * @package Volga\MetrikaLogs\Requests
 */
class LogListRequest extends RequestCore implements Request
{
    protected const METHOD = 'GET';
    protected const ADDRESS = 'https://api-metrica.yandex.net/management/v1/counter/{counterId}/logrequests';
}
