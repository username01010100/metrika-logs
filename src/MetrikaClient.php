<?php

declare(strict_types=1);

namespace Volga\MetrikaLogs;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;
use Psr\Http\Message\ResponseInterface;
use Volga\MetrikaLogs\Contracts\ParamRequest;
use Volga\MetrikaLogs\Contracts\Request;

/**
 * Class MetrikaClient
 *
 * @method Responses\LogListResponse    sendLogListRequest(Requests\LogListRequest $request)
 *
 * @package Volga\MetrikaLogs
 */
class MetrikaClient
{
    private $maps = [
        'json' => [
            Requests\LogListRequest::class => Responses\LogListResponse::class,
        ],
    ];

    /**
     * OAuth токен
     *
     * @var string
     */
    private $token;

    /**
     * Клиент HTTP
     *
     * @var GuzzleClient
     */
    private $http;

    /** @var Serializer */
    private $serializer;

    public function __construct(string $token)
    {
        $this
            ->setToken($token)
            ->setHttpClient((new GuzzleClient()));

        $this->serializer = SerializerBuilder::create()->build();
    }

    /**
     * Установка OAuth токена
     *
     * @param string $token
     * @return MetrikaClient
     */
    public function setToken(string $token): MetrikaClient
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Установка клиента HTTP
     *
     * @param GuzzleClient $httpClient
     * @return MetrikaClient
     */
    public function setHttpClient(GuzzleClient $httpClient): MetrikaClient
    {
        $this->http = $httpClient;

        return $this;
    }

    /**
     * Магический вызов метода sendRequest
     *
     * @param $name
     * @param $arguments
     * @return array|mixed|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function __call($name, $arguments)
    {
        if (0 === strpos($name, 'send')) {
            return $this->sendRequest(...$arguments);
        }

        throw new \BadMethodCallException(sprintf('Method [%s] not found in [%s].', $name, __CLASS__));
    }

    /**
     * Отправка запроса
     *
     * @param  Request  $request
     * @return array|mixed|object
     * @throws \GuzzleHttp\Exception\GuzzleException|\Exception
     */
    public function sendRequest(Request $request)
    {

        try{
            $response = $this->http->request(
                $request->getMethod(),
                $request->getAddress(),
                $this->extractOptions($request)
            );
        } catch (ClientException $exception) {
            $response = $exception->getResponse();
        }


        return $this->deserialize($request, $response);
    }

    /**
     * Извлечение параметров запроса
     *
     * @param Request $request
     * @return array
     */
    private function extractOptions(Request $request): array
    {
        $options = [
            'headers' => [
                'Authorization' => "OAuth {$this->token}",
            ],
        ];

        if ($request instanceof ParamRequest) {

            $options['query'] = $request->getParams();

        }

        return $options;
    }

    /**
     * Десериализация ответа
     *
     * @param  Request  $request
     * @param  ResponseInterface  $response
     * @return array|mixed|object
     * @throws \Exception
     */
    private function deserialize(Request $request, ResponseInterface $response)
    {

        $class = \get_class($request);

        foreach ($this->maps as $format => $map) {
            if (array_key_exists($class, $map)) {
                return $this->serializer->deserialize((string)$response->getBody(), $map[$class], $format);
            }
        }

        throw new \Exception("Class [$class] not mapped.");
    }
}
