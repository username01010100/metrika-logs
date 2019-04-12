# Logs API Яндекс.Метрики

Logs API позволяет получать неагрегированные данные, собираемые Яндекс.Метрикой. Данный API предназначен для пользователей сервиса, которые хотят самостоятельно обрабатывать статистические данные и использовать их для решения уникальных аналитических задач.

Для использования данного API необходима авторизация с помощью [авторизационного токена](https://tech.yandex.ru/metrika/doc/api2/intro/authorization-docpage/) . 

## Установка

> Минимальные требования — PHP 7.1+.

```bash
composer require Volga/metrika-logs
```

### Laravel 5.1+
```php
$client = new \Volga\MetrikaLogs\MetrikaClient('token');
```

### Иные фреймворки/без фреймворка
```php
require_once '../vendor/autoload.php';

\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');

$client = new \Volga\MetrikaLogs\MetrikaClient('token');
```

## Использование

### Оценка возможности создания запроса
Оценивает возможность создания запроса логов по его примерному размеру.

```php
use Volga\MetrikaLogs\MetrikaClient;
use Volga\MetrikaLogs\Requests\CapabilityRequest;

$client = new MetrikaClient('token');

$request = (new CapabilityRequest(counterId))
            ->setDate1(new \DateTime('2019-01-01'))
            ->setDate2(new \DateTime('yesterday'))
            ->setFields(
                [
                    'ym:pv:watchID',
                    'ym:pv:counterID',
                    'ym:pv:date',
                    'ym:pv:dateTime',
                    'ym:pv:title',
                    'ym:pv:URL',
                    'ym:pv:referer',
                ]
            )
            ->setSource('hits');

$response = $client->sendCapabilityRequest($request);
```

### Создание запроса логов
Создает запрос логов.

```php
use Volga\MetrikaLogs\MetrikaClient;
use Volga\MetrikaLogs\Requests\CreateRequest;

$client = new MetrikaClient('token');

$request = (new CreateRequest(counterId))
            ->setDate1(new \DateTime('2019-01-01'))
            ->setDate2(new \DateTime('yesterday'))
            ->setFields(
                [
                    'ym:pv:watchID',
                    'ym:pv:counterID',
                    'ym:pv:date',
                    'ym:pv:dateTime',
                    'ym:pv:title',
                    'ym:pv:URL',
                    'ym:pv:referer',
                ]
            )
            ->setSource('hits');

$response = $client->sendCreateRequest($request);
```

### Отмена не обработанного запроса логов
Отменяет еще не обработанный запрос логов.

```php
use Volga\MetrikaLogs\MetrikaClient;
use Volga\MetrikaLogs\Requests\CancelRequest;

$client = new MetrikaClient('token');

$request = new CancelRequest(counterId, requestId);

$response = $client->sendCancelRequest($request);
```

### Информация о запросе логов
Возвращает информацию о запросе логов.

```php
use Volga\MetrikaLogs\MetrikaClient;
use Volga\MetrikaLogs\Requests\InformationRequest;

$client = new MetrikaClient('token');

$request = new InformationRequest(counterId, requestId);

$response = $client->sendInformationRequest($request);
```

### Загрузка части подготовленных логов обработанного запроса
Загружает часть подготовленных логов обработанного запроса.

```php
use Volga\MetrikaLogs\MetrikaClient;
use Volga\MetrikaLogs\Requests\DownloadRequest;

$client = new MetrikaClient('token');

$request = new DownloadRequest(counterId, requestId, partNumber);

$response = $client->sendDownloadRequest($request);

if ($response instanceof \GuzzleHttp\Psr7\Stream) {
    
    while (!$response->eof()) {
        echo $response->read(1024);
    }
    
}
```

### Очистка подготовленных для загрузки логов обработанного запроса
Очищает подготовленные для загрузки логи обработанного запроса.

```php
use Volga\MetrikaLogs\MetrikaClient;
use Volga\MetrikaLogs\Requests\CleanRequest;

$client = new MetrikaClient('token');

$request = new CleanRequest(counterId, requestId);

$response = $client->sendCleanRequest($request);
```

### Список запросов логов
Возвращает список запросов логов.

```php
use Volga\MetrikaLogs\MetrikaClient;
use Volga\MetrikaLogs\Requests\LogListRequest;

$client = new MetrikaClient('token');

$request = new LogListRequest(counterId);

$response = $client->sendLogListRequest($request);
```

## Автор

- [Volga](https://github.com/Volga)

## Лицензия

Данный пакет распространяется под лицензией [MIT](http://opensource.org/licenses/MIT).
