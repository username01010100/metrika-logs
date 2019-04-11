<?php

declare(strict_types=1);

namespace Volga\MetrikaLogs\Contracts;

interface ParamRequest extends Request
{
    /**
     * Параметры запроса
     *
     * @return array
     */
    public function getParams(): array;
}