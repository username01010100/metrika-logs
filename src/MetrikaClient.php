<?php

declare(strict_types=1);

namespace Volga\MetrikaLogs;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Stream;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;
use Psr\Http\Message\ResponseInterface;
use Volga\MetrikaLogs\Contracts\DeserializeResponseInterface;
use Volga\MetrikaLogs\Contracts\ParamRequest;
use Volga\MetrikaLogs\Contracts\Request;

/**
 * Class MetrikaClient
 *
 * @method Responses\LogListResponse    sendLogListRequest(Requests\LogListRequest $request)
 * @method Responses\CapabilityResponse    sendCapabilityRequest(Requests\CapabilityRequest $request)
 * @method Responses\InformationResponse    sendInformationRequest(Requests\InformationRequest $request)
 * @method Responses\DownloadResponse|Stream    sendDownloadRequest(Requests\DownloadRequest $request)
 * @method Responses\CleanResponse    sendCleanRequest(Requests\CleanRequest $request)
 * @method Responses\CancelResponse    sendCancelRequest(Requests\CancelRequest $request)
 * @method Responses\CreateResponse    sendCreateRequest(Requests\CreateRequest $request)
 *
 * @package Volga\MetrikaLogs
 */
class MetrikaClient
{
    private $maps = [
        'json' => [
            Requests\LogListRequest::class => Responses\LogListResponse::class,
            Requests\CapabilityRequest::class => Responses\CapabilityResponse::class,
            Requests\InformationRequest::class => Responses\InformationResponse::class,
            Requests\DownloadRequest::class => Responses\DownloadResponse::class,
            Requests\CleanRequest::class => Responses\CleanResponse::class,
            Requests\CancelRequest::class => Responses\CancelResponse::class,
            Requests\CreateRequest::class => Responses\CreateResponse::class,
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

    /**
     * Сериалайзер
     *
     * @var Serializer
     */
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
     * @param  string  $token
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
     * @param  GuzzleClient  $httpClient
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

        try {
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
     * @param  Request  $request
     * @return array
     */
    private function extractOptions(Request $request): array
    {
        $options = [
            'headers' => [
                'Authorization' => "OAuth {$this->token}",
            ],
            'stream' => true,
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

                if ((new \ReflectionClass($map[$class]))->implementsInterface(DeserializeResponseInterface::class)) {
                    return call_user_func([$map[$class], 'deserialize'], $this, $response, $format);
                }

                return $this->serializer->deserialize(
                    (string) $response->getBody()->getContents(),
                    $map[$class],
                    $format
                );
            }

        }

        throw new \Exception("Class [$class] not mapped.");
    }

    /**
     * Сериалайзер
     *
     * @return Serializer
     */
    public function getSerializer(): Serializer
    {
        return $this->serializer;
    }
}
