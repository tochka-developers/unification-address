# Unification Address

Реализация парсинга адреса РФ на составные части для Laravel. На данный момент парсинг делается с помощью апи Почты России и апи сервиса DaData (стандартизация). Результаты запросов кешируются, управление через настройки кеширования Laravel.

Поддерживаемые версии:
* Laravel | Lumen >= 5.0
* PHP 7.4 | 8.0

# Установка
Установка через composer:
```shell script
composer require tochka/unification-address
```
Публикуем конфигурацию для всех пакетов:
```shell script
php artisan vendor:publish
```

Для Lumen нужно самостоятельно подключить `UnifAddressServiceProvider`

# Конфигурация
```php
return [
    // Предфильтр для предварительной обработки строки адреса по кастомным правилам.
    // По-умолчанию не производится. Можно реализовать на стороне внешнего сервиса.
    // Должен реализовать интерфейс Tochka\Unif\Address\Contracts\PreFilterInterface
    'pre_filter_handler' => null /*\App\Service\AddressPreFilter::class*/,
    // Список источников обработки строки адреса. Адрес парсится последовательно, до первого успешного результата.
    // Если ни один из источников не дал приемлемого результата - вернется null.
    'processing_sources' => [
        // Класс можно отнаследовать или реализовать свой. При самостоятельной реализации источника
        // обработки класс нужно реализовать от интерфейса Tochka\Unif\Address\Contracts\SourceInterface
        \Tochka\Unif\Address\Sources\RusPost::class => [
            // Здесь нужно передавать авторизационные данные источника
            'token' => env('RusPost_ACCESS_TOKEN'),
            'user'  => env('RusPost_USER'),
            'pass'  => env('RusPost_PASS'),
        ], 
        \Tochka\Unif\Address\Sources\DaData::class => [
            // Здесь нужно передавать авторизационные данные источника
            'token' => env('DADATA_TOKEN'),
            'secret' => env('DADATA_SECRET')
        ]
    ]
];
```

# Пример
```php
$address = '115114  Москва г. наб. Дербеневская, д. 11 к А - 311';
$enrichedAddress = app(UnifAddress::class)->parsing($address);
```
В `$enrichedAddress` возвращается массив, разбитого по частям, адреса
```php
[
  "postindex" => "115114" // почтовый индекс
  "region" => "г Москва" // регион, область, край, республика
  "area" => null // район в регионе
  "city" => "Москва" // город, населенный пункт
  "isSettlement" => false // Признак населенного пункта (пгт, деревня, село, хутор)
  "address" => "наб Дербеневская, д 11А" // адрес
  "street" => "наб Дербеневская" // улица
  "house" => "11А" // номер дома
  "block" => null // корпус/строение
  "flat" => null // квартира/офис
  "unparsed" => "311" // нераспознанная часть адреса
  "quality" => "good" // Качество распознавания адреса: good - доп. обработка не требуется, need_check - нужна проверка
]
```