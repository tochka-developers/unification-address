<?php

declare(strict_types=1);

namespace Tochka\Unif\Address\Sources;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Tochka\Unif\Address\Contracts\SourceInterface;

class DaData implements SourceInterface
{
    public const HOST = 'https://dadata.ru';
    /**
     * @var array
     */
    private $authData;

    /**
     * @param array $authData
     */
    public function __construct(array $authData)
    {
        $this->authData = $authData;
    }

    /**
     * @throws \JsonException
     */
    public function processing(string $address): array
    {
        $uri = self::HOST . '/api/v2/clean/address';

        $response = (new Client())->post($uri, [
            RequestOptions::HEADERS => [
                'Authorization' => 'Token ' . $this->authData['token'],
                'X-Secret'      => $this->authData['secret'],
            ],
            RequestOptions::JSON    => [$address],
            RequestOptions::TIMEOUT => 30,
        ]);

        $body = (string)$response->getBody();

        return $this->resultHandler(json_decode($body, true, 512, JSON_THROW_ON_ERROR));
    }

    public function resultHandler(array $results): array
    {
        $data = [];

        $raw = array_shift($results);

        // почтовый индекс
        $data['postindex'] = $raw['postal_code'];

        // регион, область, край, республика
        $data['region'] = $raw['region_with_type'];

        // район в регионе
        $data['area'] = $raw['area_with_type'];

        // город, населенный пункт
        $data['city'] = $raw['city'] ?? $raw['settlement'] ?? $raw['region'] ?? null;
        if ($raw['settlement'] !== null) {
            if (preg_match('/(.*?) \((.*?) (.*?)\)/su', $raw['settlement'], $matches) && isset($matches[3])) {
                $data['city'] = $matches[3];
            } elseif (\in_array(mb_strtolower($raw['settlement_type']), [
                'с',
                'п',
                'д',
                'ст-ца',
                'автодорога',
                'пгт',
                'х',
                'рп',
                'ж/д_ст',
                'ш',
                'тер. днп',
                'дп',
            ], true)) {
                $data['city'] = $raw['settlement'];
            }
        }

        // Признак отправки не в город
        $data['isSettlement'] = $raw['settlement'] !== null;

        // адрес
        $isMcR = $raw['settlement'] !== null
            && \in_array(mb_strtolower($raw['settlement_type']), ['кв-л', 'р-н', 'мкр', 'жилрайон'], true);
        if ($isMcR) {
            $data['address'][] = $raw['settlement_with_type'];
        }
        if ($raw['street']) {
            $data['address'][] = $raw['street_with_type'];
        }
        if ($raw['house']) {
            $data['address'][] = $raw['house_type'] . ' ' . $raw['house'];
        }
        if ($raw['block']) {
            $data['address'][] = $raw['block_type_full'] . ' ' . $raw['block'];
        }
        if ($raw['flat']) {
            $data['address'][] = $raw['flat_type'] . ' ' . $raw['flat'];
        }
        $data['address'] = implode(', ', $data['address']);

        // улица
        $data['street'] = $raw['street'];

        // номер дома
        $data['house'] = $raw['house'];

        // корпус/строение
        $data['block'] = $raw['block'];

        // квартира/офис
        $data['flat'] = $raw['flat'];

        // нераспознанная часть адреса
        $data['unparsed'] = $raw['unparsed_parts'] ?? null;

        // Качество распознавания адреса
        $data['quality'] = \in_array(
            $raw['qc_complete'],
            [0, 10, 5, 8, 9],
            true
        ) ? self::QUALITY_GOOD : self::QUALITY_NEED_CHECK;

        return $data;
    }
}