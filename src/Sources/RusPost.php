<?php

declare(strict_types=1);

namespace Tochka\Unif\Address\Sources;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Log;
use Tochka\Unif\Address\Contracts\SourceInterface;

/**
 * @link https://otpravka.pochta.ru/specification#/nogroup-normalization_adress
 */
class RusPost implements SourceInterface
{
    public const HOST = 'https://otpravka-api.pochta.ru';
    /**
     * @var array
     */
    private $authData;

    public function __construct(array $authData)
    {
        $this->authData = $authData;
    }

    /**
     * Обработка сырых данные, приведение к формату
     *
     * @param string $address Адрес строкой
     * @param bool   $getRaw  Вернуть "сырые" данные, без обработки
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     */
    public function processing(string $address, bool $getRaw = false): ?array
    {
        $uri = self::HOST . '/1.0/clean/address';

        $response = (new Client())->post($uri, [
            RequestOptions::HEADERS     => [
                'Authorization'        => 'AccessToken ' . $this->authData['token'],
                'X-User-Authorization' => 'Basic ' . base64_encode(
                        $this->authData['user'] . ':' . $this->authData['pass']
                    ),
            ],
            RequestOptions::JSON        => [['id' => random_int(0, 5000), 'original-address' => $address]],
            RequestOptions::TIMEOUT     => 30,
            RequestOptions::HTTP_ERRORS => false,
        ]);

        $body = $response->getBody()->getContents();
        $data = json_decode($body, true, 512, JSON_THROW_ON_ERROR);

        if ($response->getStatusCode() !== 200) {
            Log::channel(config('unif.logChannel'))
                ->error('Source ' . class_basename(__CLASS__) . ' error', $data);
            return null;
        }

        if ($getRaw) {
            return $data;
        }

        return $this->resultHandler($data);
    }

    public function resultHandler(array $results): array
    {
        $data = [];
        $isSettlement = false; // Признак отправки не в город

        $raw = array_shift($results);

        // почтовый индекс
        $data['postindex'] = $raw['index'] ?? null;

        // регион, область, край, республика
        if (!empty($raw['region'])) {
            $data['region'] = $raw['region'];
            $isSettlement = mb_stripos($data['region'], 'москва') !== false
                || mb_stripos($data['region'], 'петербург') !== false;
        }

        // район в регионе
        $data['area'] = $raw['area'] ?? null;

        // город, населенный пункт
        if (isset($raw['place'])) {
            $placeParts = explode(' ', $raw['place']);
            $cityType = array_shift($placeParts);
            $data['city'] = implode(' ', $placeParts);
            $isSettlement = $isSettlement === false && mb_strtolower(trim($cityType)) !== 'г';
        }

        // адрес
        $address = [];
        if (isset($raw['location'])) {
            $location = str_replace(['мкр.', 'тер.'], ['мкр', 'тер'], $raw['location']);

            $address[] = $location;

            // Случаи типа ст-ца Натухаевская, с. Нагаево и пр
            if ($isSettlement === false) {
                $locations = explode(' ', $location);
                $isSettlement = isset($locations[0]) && !\in_array($locations[0], ['мкр', 'р-н'], true);
            }
        }
        if (isset($raw['street'])) {
            $address[] = $raw['street'];
        }
        if (isset($raw['house'])) {
            $address[] = 'д ' . $raw['house'];
        }
        if (isset($raw['vladenie'])) {
            $address[] = 'д ' . $raw['vladenie'];
        }
        if (isset($raw['building'])) {
            $address[] = 'стр ' . $raw['building'];
        }
        if (isset($raw['num-address-type']) && $raw['quality-code'] === 'POSTAL_BOX') {
            $address[] = 'а/я ' . $raw['num-address-type'];
        }
        $address = implode(', ', $address);
        if (isset($raw['letter'])) {
            $address .= ', лит ' . $raw['letter'];
        }
        if (isset($raw['slash'])) {
            $address .= mb_strtoupper($raw['slash']);
        }
        if (isset($raw['corpus'])) {
            $address .= ', к ' . mb_strtoupper($raw['corpus']);
        }
        if (isset($raw['room'])) {
            $address .= ', кв ' . $raw['room'];
        }
        if (isset($raw['office'])) {
            $address .= ', ' . $raw['office'];
        }
        $data['address'] = $address;

        // улица
        $data['street'] = $raw['street'] ?? null;

        // номер дома
        $house = [];
        if (isset($raw['house'])) {
            $house[] = $raw['house'];
        }
        if (isset($raw['vladenie'])) {
            $house[] = $raw['vladenie'];
        }
        if (isset($raw['slash'])) {
            $house[] = mb_strtoupper($raw['slash']);
        }
        if (isset($raw['corpus'])) {
            $house[] = ' к ' . mb_strtoupper($raw['corpus']);
        }
        $data['house'] = implode('', $house);

        // корпус/строение
        $data['block'] = $raw['block'] ?? null;

        // квартира/офис
        $data['flat'] = $raw['room'] ?? null;

        // Не обработанная часть адреса
        $data['unparsed'] = null;

        // Признак отправки не в город
        $data['isSettlement'] = $isSettlement;

        $data['quality'] =
            \in_array($raw['quality-code'], ['GOOD', 'POSTAL_BOX', 'ON_DEMAND', 'UNDEF_05'])
            && \in_array($raw['validation-code'], ['VALIDATED', 'OVERRIDDEN', 'CONFIRMED_MANUALLY'])
                ? self::QUALITY_GOOD
                : self::QUALITY_NEED_CHECK;

        return $data;
    }
}