<?php

declare(strict_types=1);

namespace Tochka\Unif\Address\Sources;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Log;
use Tochka\Unif\Address\Contracts\SourceInterface;

/**
 * @link https://dadata.ru/api/clean/address/
 */
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
        $data = $this->sendRequest($address);

        $data = array_shift($data);

        if (empty($data)) {
            return null;
        }

        if ($data['unparsed_parts']) {
            $address = trim(preg_replace('/' . $data['unparsed_parts'] . '/iu', '', $address));

            $data = $this->sendRequest($address);
            $data = array_shift($data);
        }

        if ($getRaw) {
            return $data;
        }

        return $this->resultHandler($data);
    }

    /**
     * @param string $address
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     */
    private function sendRequest(string $address): ?array
    {
        $uri = self::HOST . '/api/v2/clean/address';

        $response = (new Client())->post($uri, [
            RequestOptions::HEADERS     => [
                'Authorization' => 'Token ' . $this->authData['token'],
                'X-Secret'      => $this->authData['secret'],
            ],
            RequestOptions::JSON        => [$address],
            RequestOptions::TIMEOUT     => 30,
            RequestOptions::HTTP_ERRORS => false,
        ]);

        $body = $response->getBody()->getContents();

        if ($response->getStatusCode() !== 200) {
            Log::channel(config('unif.logChannel'))
                ->error('Source ' . class_basename(__CLASS__) . ' error', [$body]);
            return null;
        }

        return json_decode($body, true, 512, JSON_THROW_ON_ERROR);
    }

    public function resultHandler(array $results): array
    {
        $data = [];

        // почтовый индекс
        $data['postindex'] = $results['postal_code'];

        // регион, область, край, республика
        $data['region'] = $results['region_type'] . ' ' . $results['region'];

        // район в регионе
        $data['area'] = $results['area'] !== null ? ($results['area_type'] . ' ' . $results['area']) : null;

        // город, населенный пункт
        $data['city'] = $results['city'] ?? $results['settlement'] ?? $results['region'] ?? null;
        if ($results['settlement'] !== null) {
            if (preg_match('/(.*?) \((.*?) (.*?)\)/su', $results['settlement'], $matches) && isset($matches[3])) {
                $data['city'] = $matches[3];
            } elseif (\in_array(mb_strtolower($results['settlement_type']), [
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
                $data['city'] = $results['settlement'];
            }
        }

        // Признак отправки не в город
        if ($results['region_type_full'] === 'город') {
            $data['isSettlement'] = false;
        } else {
            $data['isSettlement'] = !isset($results['city_type_full']) || $results['city_type_full'] !== 'город';
        }

        // адрес
        $isMcR = $results['settlement'] !== null
            && \in_array(mb_strtolower($results['settlement_type']), ['кв-л', 'р-н', 'мкр', 'жилрайон'], true);
        if ($isMcR) {
            $data['address'][] = trim(preg_replace('/\((.*?)\)/', '', $results['settlement_with_type']));
        }
        if ($results['street']) {
            $data['address'][] = $results['street_with_type'];
        }
        if ($results['house']) {
            $data['address'][] = $results['house_type'] . ' ' . $results['house'];
        }
        if ($results['block']) {
            $data['address'][] = $results['block_type_full'] . ' ' . $results['block'];
        }
        if ($results['flat']) {
            $data['address'][] = $results['flat_type'] . ' ' . $results['flat'];
        }
        if ($results['postal_box']) {
            $data['address'][] = 'а/я ' . $results['postal_box'];
        }
        if (!empty($data['address'])) {
            $data['address'] = implode(', ', $data['address']);
        }

        // улица
        $data['street'] = $results['street_with_type'];

        // номер дома
        $data['house'] = $results['house'];

        // корпус/строение
        $data['block'] = $results['block'];

        // квартира/офис
        $data['flat'] = $results['flat'];

        // нераспознанная часть адреса
        $data['unparsed'] = $results['unparsed_parts'] ?? null;

        // Качество распознавания адреса
        $data['quality'] =
            \in_array($results['qc_complete'], [0, 10, 5, 8], true)
            || ($results['qc_complete'] === 9 && !\in_array($results['qc'], [1, 3], true))
                ? self::QUALITY_GOOD
                : self::QUALITY_NEED_CHECK;

        return $data;
    }
}