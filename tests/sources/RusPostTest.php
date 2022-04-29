<?php

namespace Tochka\Unif\Address\Tests\Sources;

use Tochka\Unif\Address\Contracts\SourceInterface as Contract;

class RusPostTest extends AbstractSource
{

    /**
     * @testdox      resultHandler address
     *
     * @dataProvider providerAddressRusPost
     *
     * @param $in
     * @param $out
     */
    public function testAddress($in, $out): void
    {
        $this->assertEquals($out, (new \Tochka\Unif\Address\Sources\RusPost([]))->resultHandler($in));
    }

    /**/
    public function providerAddressRusPost(): array
    {
        $res = [
            'set #1'   => [
                [
                    [
                        'address-type'     => 'DEFAULT',
                        'corpus'           => 'а',
                        'house'            => '11',
                        'id'               => '295295912',
                        'index'            => '115114',
                        'original-address' => '115114 г. Москва Москва г. наб. Дербеневская, д. 11 к А , 311',
                        'place'            => 'г Москва',
                        'place-guid'       => '0c5b2444-70a0-4932-980c-b4dc0d3f02b5',
                        'quality-code'     => 'GOOD',
                        'region'           => 'г Москва',
                        'region-guid'      => '0c5b2444-70a0-4932-980c-b4dc0d3f02b5',
                        'room'             => '311',
                        'street'           => 'наб Дербеневская',
                        'street-guid'      => '1d5cd93a-d4c8-48b4-a02c-d849882376c3',
                        'validation-code'  => 'VALIDATED',
                    ],
                ],
                [],
            ],
            'set #1.1' => [
                [
                    [
                        'address-guid'     => 'e4e65acd-61c6-41ce-8ef3-c0254fd07534',
                        'address-type'     => 'DEFAULT',
                        'corpus'           => '1',
                        'house'            => '13/17',
                        'id'               => '431',
                        'index'            => '115114',
                        'original-address' => '115114  г. Москва наб. Дербеневская, д. 13/17, стр. к. 1, оф. кв. 104',
                        'place'            => 'г Москва',
                        'place-guid'       => '0c5b2444-70a0-4932-980c-b4dc0d3f02b5',
                        'quality-code'     => 'GOOD',
                        'region'           => 'г Москва',
                        'region-guid'      => '0c5b2444-70a0-4932-980c-b4dc0d3f02b5',
                        'room'             => '104',
                        'street'           => 'наб Дербеневская',
                        'street-guid'      => '1d5cd93a-d4c8-48b4-a02c-d849882376c3',
                        'validation-code'  => 'VALIDATED',
                    ],
                ],
                [],
            ],
            'set #2'   => [
                [
                    [
                        'address-guid'     => 'aa17ca5a-0ae4-4717-b3af-6ea2550c5aab',
                        'address-type'     => 'DEFAULT',
                        'house'            => '3',
                        'id'               => '295295912',
                        'index'            => '420100',
                        'original-address' => '420100 Казань Рашида Вагапова, 3 - 97',
                        'place'            => 'г Казань',
                        'place-guid'       => '93b3df57-4c89-44df-ac42-96f05e9cd3b9',
                        'quality-code'     => 'GOOD',
                        'region'           => 'Респ Татарстан',
                        'region-guid'      => '0c089b04-099e-4e0e-955a-6bf1ce525f1a',
                        'room'             => '97',
                        'street'           => 'ул Рашида Вагапова',
                        'street-guid'      => 'cf73025e-fa80-4c6c-a7a8-c16ccc16dd47',
                        'validation-code'  => 'VALIDATED',
                    ],
                ],
                [],
            ],
            'set #3'   => [
                [
                    [
                        'address-guid'     => '13b912ee-205d-4ed7-93b2-1b7b0339412c',
                        'address-type'     => 'DEFAULT',
                        'house'            => '99',
                        'id'               => '295295912',
                        'index'            => '626157',
                        'location'         => 'мкр 7',
                        'original-address' => 'г. Тобольск Тюменская обл. мкр. 7, д. 99 - 105',
                        'place'            => 'г Тобольск',
                        'place-guid'       => '6d7c3e9e-8d6d-490a-a650-8257dbf5ec36',
                        'quality-code'     => 'GOOD',
                        'region'           => 'обл Тюменская',
                        'region-guid'      => '54049357-326d-4b8f-b224-3c6dc25d6dd3',
                        'room'             => '105',
                        'validation-code'  => 'VALIDATED',
                    ],
                ],
                [],
            ],
            'set #4'   => [
                [
                    [
                        'address-guid'     => '93af4577-d394-4c5b-8295-07999a78dfb9',
                        'address-type'     => 'DEFAULT',
                        'area'             => 'р-н Волховский',
                        'house'            => '34',
                        'id'               => '295295912',
                        'index'            => '187450',
                        'location'         => 'мкр В',
                        'original-address' => '187450 Волховский Новая Ладога В , ДОМ 34 - кв 13',
                        'place'            => 'г Новая Ладога',
                        'place-guid'       => '2145f2cb-3ec2-4c1d-bd52-f84b2858c6a9',
                        'quality-code'     => 'GOOD',
                        'region'           => 'обл Ленинградская',
                        'region-guid'      => '6d1ebb35-70c6-4129-bd55-da3969658f5d',
                        'room'             => '13',
                        'validation-code'  => 'VALIDATED',
                    ],
                ],
                [],
            ],
            'set #5'   => [
                [
                    [
                        'address-guid'     => '8847a2cb-977d-4273-bc89-f9c58e623973',
                        'address-type'     => 'DEFAULT',
                        'house'            => '13',
                        'id'               => '295295912',
                        'index'            => '654038',
                        'location'         => 'р-н Заводской',
                        'original-address' => '654038 Новокузнецк  Заводской  Тореза, ДОМ 13 - кв 3',
                        'place'            => 'г Новокузнецк',
                        'place-guid'       => 'b28b6f6f-1435-444e-95a6-68c499b0d27a',
                        'quality-code'     => 'GOOD',
                        'region'           => 'обл Кемеровская область - Кузбасс',
                        'region-guid'      => '393aeccb-89ef-4a7e-ae42-08d5cebc2e30',
                        'room'             => '3',
                        'street'           => 'ул Тореза',
                        'street-guid'      => '6cc45b4a-242d-4dd0-876d-2e924c0c4dd4',
                        'validation-code'  => 'VALIDATED',
                    ],
                ],
                [],
            ],
            'set #6'   => [
                [
                    [
                        'address-guid'     => 'c54d87cf-f06b-440b-8266-67ae701bc836',
                        'address-type'     => 'DEFAULT',
                        'area'             => 'р-н Щучанский',
                        'house'            => '94',
                        'id'               => '295295912',
                        'index'            => '641010',
                        'original-address' => '641010 Щучанский  Нифанка 1 Мая, ДОМ 94',
                        'place'            => 'с Нифанка',
                        'place-guid'       => 'ad084303-6620-4dec-94e8-2987ec6a49ab',
                        'quality-code'     => 'GOOD',
                        'region'           => 'обл Курганская',
                        'region-guid'      => '4a3d970f-520e-46b9-b16c-50d4ca7535a8',
                        'street'           => 'ул 1 Мая',
                        'street-guid'      => '756dcce6-3cb2-4ca8-890b-343ebe02d126',
                        'validation-code'  => 'VALIDATED',
                    ],
                ],
                [],
            ],
            'set #7'   => [
                [
                    [
                        'address-guid'     => '23e52bb6-cd5c-4f0f-9d07-6c053abe13ab',
                        'address-type'     => 'DEFAULT',
                        'area'             => 'р-н Елизовский',
                        'house'            => '21',
                        'id'               => '295295912',
                        'index'            => '684017',
                        'location'         => 'мкр Молодежный',
                        'original-address' => '684017 Камчатский край. п. Светлый ул. Невельского (Молодежный мкр), д. 21',
                        'place'            => 'п Светлый',
                        'place-guid'       => 'fc4130e9-1c6e-4397-a2d6-dca38aeea418',
                        'quality-code'     => 'GOOD',
                        'region'           => 'край Камчатский',
                        'region-guid'      => 'd02f30fc-83bf-4c0f-ac2b-5729a866a207',
                        'street'           => 'ул Невельского',
                        'street-guid'      => '0f2fa959-a37e-436e-a346-56c67093e108',
                        'validation-code'  => 'VALIDATED',
                    ],
                ],
                [],
            ],
            'set #8'   => [
                [
                    [
                        'address-guid'     => '987e125c-f979-48be-a828-360c5167a5dc',
                        'address-type'     => 'DEFAULT',
                        'area'             => 'р-н Иркутский',
                        'house'            => '4',
                        'id'               => '295295912',
                        'index'            => '664058',
                        'location'         => 'кв-л Стрижи',
                        'original-address' => '664528 Иркутская обл. рп. Маркова кв-л. Стрижи, д. 4 - 62',
                        'place'            => 'рп Маркова',
                        'place-guid'       => '4e174bad-c41f-492c-962e-c03374f1d7e1',
                        'quality-code'     => 'GOOD',
                        'region'           => 'обл Иркутская',
                        'region-guid'      => '6466c988-7ce3-45e5-8b97-90ae16cb1249',
                        'room'             => '62',
                        'validation-code'  => 'VALIDATED',
                    ],
                ],
                [],
            ],
            'set #9'   => [
                [
                    [
                        'address-type'     => 'DEFAULT',
                        'house'            => '4',
                        'id'               => '295295912',
                        'index'            => '410039',
                        'location'         => 'мкр. Шарковка',
                        'original-address' => '410039 Саратов  Шарковка , ДОМ 4 - кв 64',
                        'place'            => 'г Саратов',
                        'place-guid'       => 'bf465fda-7834-47d5-986b-ccdb584a85a6',
                        'quality-code'     => 'GOOD',
                        'region'           => 'обл Саратовская',
                        'region-guid'      => 'df594e0e-a935-4664-9d26-0bae13f904fe',
                        'room'             => '64',
                        'validation-code'  => 'VALIDATED',
                    ],
                ],
                [],
            ],
            'set #10'  => [
                [
                    [
                        'address-guid'     => '4a620c8a-f493-4c2b-a687-7b4f48595312',
                        'address-type'     => 'DEFAULT',
                        'area'             => 'р-н Краснозоренский',
                        'house'            => '22',
                        'id'               => '295295912',
                        'index'            => '303660',
                        'original-address' => '303660 Орловская д. Протасово ул Центральная, 22',
                        'place'            => 'д Протасово',
                        'place-guid'       => 'a63b4eed-f633-4d84-828d-6e807462d5e7',
                        'quality-code'     => 'GOOD',
                        'region'           => 'обл Орловская',
                        'region-guid'      => '5e465691-de23-4c4e-9f46-f35a125b5970',
                        'street'           => 'ул Центральная',
                        'street-guid'      => '639b2ebd-7f15-486d-b962-33ac4d408bd4',
                        'validation-code'  => 'VALIDATED',
                    ],
                ],
                [],
            ],
            'set #11'  => [
                [
                    [
                        'address-type'     => 'DEFAULT',
                        'area'             => 'р-н Крапивинский',
                        'house'            => '11',
                        'id'               => '295295912',
                        'index'            => '652458',
                        'original-address' => '652458 Крапивинский  Бердюгино Центральная, ДОМ 11 - кв 1',
                        'place'            => 'д Бердюгино',
                        'place-guid'       => 'f3ed5ac4-84a7-4491-ab18-2390c36abcd5',
                        'quality-code'     => 'GOOD',
                        'region'           => 'обл Кемеровская область - Кузбасс',
                        'region-guid'      => '393aeccb-89ef-4a7e-ae42-08d5cebc2e30',
                        'room'             => '1',
                        'street'           => 'ул Центральная',
                        'street-guid'      => '8d9bae00-c876-431a-b2d3-02e8f45394eb',
                        'validation-code'  => 'VALIDATED',
                    ],
                ],
                [],
            ],
            'set #12'  => [
                [
                    [
                        'address-guid'     => 'eae74ac3-b991-4082-863b-c9d5d4e69661',
                        'address-type'     => 'DEFAULT',
                        'area'             => 'р-н Калининский',
                        'house'            => '13',
                        'id'               => '295295912',
                        'index'            => '353780',
                        'original-address' => '353780 р-н Калининский ст-ца Калининская ул Пролетарская, д 13 - оф',
                        'place'            => 'ст-ца Калининская',
                        'place-guid'       => 'f56bf504-52e4-4c03-96b1-fe04a9543fa4',
                        'quality-code'     => 'GOOD',
                        'region'           => 'край Краснодарский',
                        'region-guid'      => 'd00e1013-16bd-4c09-b3d5-3cb09fc54bd8',
                        'street'           => 'ул Пролетарская',
                        'street-guid'      => '736922bd-9090-4536-9d28-6cbb27f13abd',
                        'validation-code'  => 'VALIDATED',
                    ],
                ],
                [
                    'unparsed' => null,
                    'quality'  => Contract::QUALITY_GOOD,
                ],
            ],
            'set #13'  => [
                [
                    [
                        'address-type'     => 'DEFAULT',
                        'house'            => '6',
                        'id'               => '295295912',
                        'index'            => '143421',
                        'location'         => 'тер. автодорога Балтия',
                        'original-address' => '143421 Московская автодорога Балтия 26 км бизнес-центр Рига-Ленд, 6',
                        'place'            => 'г Красногорск',
                        'place-guid'       => '63fcf18a-365e-451f-baee-8d09ac50b773',
                        'quality-code'     => 'GOOD',
                        'region'           => 'обл Московская',
                        'region-guid'      => '29251dcf-00a1-4e34-98d4-5c47484a36d4',
                        'street'           => 'км 26-й',
                        'street-guid'      => '8aa27461-498f-4be3-821b-ddc379c673ca',
                        'validation-code'  => 'VALIDATED',
                    ],
                ],
                [
                    'city'         => 'Красногорск',
                    'area'         => null,
                    'street'       => 'км 26-й',
                    'isSettlement' => false,
                    'address'      => 'тер автодорога Балтия, км 26-й, д 6',
                ],
            ],
            'set #14'  => [
                [
                    [
                        'address-guid'     => 'b37e0e5a-2c9f-4d22-a1ef-b92a1ade6a94',
                        'address-type'     => 'DEFAULT',
                        'area'             => 'р-н Волжский',
                        'house'            => '2',
                        'id'               => '295295912',
                        'index'            => '443528',
                        'original-address' => '443528 пгт ойкерамика Петра Монастырского, 2',
                        'place'            => 'пгт Стройкерамика',
                        'place-guid'       => '99193da5-17be-475b-8340-737fe2fb2b72',
                        'quality-code'     => 'GOOD',
                        'region'           => 'обл Самарская',
                        'region-guid'      => 'df3d7359-afa9-4aaa-8ff9-197e73906b1c',
                        'street'           => 'ул Петра Монастырского',
                        'street-guid'      => '74623149-895c-4c0c-8dcc-64c1026e1063',
                        'validation-code'  => 'VALIDATED',
                    ],
                ],
                [
                    'unparsed' => null,
                    'quality'  => Contract::QUALITY_GOOD,
                ],
            ],
            'set #15'  => [
                [
                    [
                        'address-type'     => 'DEFAULT',
                        'area'             => 'р-н Аксайский',
                        'house'            => '9',
                        'id'               => '295295912',
                        'index'            => '346701',
                        'original-address' => '346701 Аксайский  Рыбацкий 1-я Донская, ДОМ 9 - кв 20',
                        'place'            => 'х Рыбацкий',
                        'place-guid'       => 'cdc5790c-ce19-49a0-9f53-f416fb93bf4c',
                        'quality-code'     => 'GOOD',
                        'region'           => 'обл Ростовская',
                        'region-guid'      => 'f10763dc-63e3-48db-83e1-9c566fe3092b',
                        'room'             => '20',
                        'street'           => 'ул 1-я Донская',
                        'street-guid'      => 'aef4335b-f46a-424b-b475-5b41aedea57a',
                        'validation-code'  => 'VALIDATED',
                    ],
                ],
                [],
            ],
            'set #16'  => [
                [
                    [
                        'address-guid'     => 'c13a72d3-22e4-4588-998c-568347d10772',
                        'address-type'     => 'DEFAULT',
                        'area'             => 'г Одинцово',
                        'house'            => '2',
                        'id'               => '295295912',
                        'index'            => '143050',
                        'original-address' => '143050 р-н Одинцовский рп Большие Вязёмы ш Можайское, д 2 - кв. 29',
                        'place'            => 'рп Большие Вязёмы',
                        'place-guid'       => 'e37874db-2e3a-4baf-9027-6c7bf36839a3',
                        'quality-code'     => 'GOOD',
                        'region'           => 'обл Московская',
                        'region-guid'      => '29251dcf-00a1-4e34-98d4-5c47484a36d4',
                        'room'             => '29',
                        'street'           => 'ш Можайское',
                        'street-guid'      => '184337a1-953b-49fa-86b2-bb49d052b99e',
                        'validation-code'  => 'VALIDATED',
                    ],
                ],
                [],
            ],
            'set #17'  => [
                [
                    [
                        'address-guid'     => 'b608a25c-2d64-4b62-8101-da976883a2cc',
                        'address-type'     => 'DEFAULT',
                        'area'             => 'р-н Добринский',
                        'house'            => '2',
                        'id'               => '295295912',
                        'index'            => '399420',
                        'original-address' => '399420 р-н ДОБРИНСКИЙ ж/д_ст ПЛАВИЦА ул СТРОИТЕЛЕЙ, ДОМ 2 - кв. 6',
                        'place'            => 'ж/д_ст Плавица',
                        'place-guid'       => '64d2fe57-2ccd-4012-9614-944aef4a29f8',
                        'quality-code'     => 'GOOD',
                        'region'           => 'обл Липецкая',
                        'region-guid'      => '1490490e-49c5-421c-9572-5673ba5d80c8',
                        'room'             => '6',
                        'street'           => 'ул Строителей',
                        'street-guid'      => 'ce926ab7-4d9d-4998-b3fe-383fbbb4c89c',
                        'validation-code'  => 'VALIDATED',
                    ],
                ],
                [],
            ],
            'set #18'  => [
                [
                    [
                        'address-type'     => 'DEFAULT',
                        'area'             => 'г Ногинск',
                        'house'            => '196',
                        'id'               => '295295912',
                        'index'            => '142400',
                        'original-address' => '142434 тер. ДНП Зимородок -, 196',
                        'place'            => 'тер. ДНП Зимородок',
                        'place-guid'       => '69bba748-4877-458b-9ec3-e43db46b5096',
                        'quality-code'     => 'GOOD',
                        'region'           => 'обл Московская',
                        'region-guid'      => '29251dcf-00a1-4e34-98d4-5c47484a36d4',
                        'validation-code'  => 'VALIDATED',
                    ],
                ],
                [
                    'quality' => Contract::QUALITY_GOOD,
                    'city'    => 'ДНП Зимородок',
                ],
            ],
            'set #19'  => [
                [
                    [
                        'address-guid'     => '6c93148b-2b42-41df-be24-86038fd334a9',
                        'address-type'     => 'DEFAULT',
                        'id'               => '295295912',
                        'location'         => 'п Оболенск местность Район рп Оболенск улица Строителей стр9',
                        'original-address' => '3005047 Москва г. г Курск ул Дейнеки, д 19кв, стр. ка, оф. кв 45',
                        'place'            => 'г Серпухов',
                        'place-guid'       => 'efc02a6a-273b-4a49-aef9-a5606ef8591c',
                        'quality-code'     => 'UNDEF_03',
                        'region'           => 'обл Московская',
                        'region-guid'      => '29251dcf-00a1-4e34-98d4-5c47484a36d4',
                        'validation-code'  => 'NOT_VALIDATED_HOUSE_WITHOUT_STREET_OR_NP',
                    ],
                ],
                [
                    'isSettlement' => true,
                ],
            ],
            'set #20'  => [
                [
                    [
                        'address-type'     => 'PO_BOX',
                        'id'               => '295295912',
                        'index'            => '630126',
                        'num-address-type' => '8',
                        'original-address' => '630126 г.Новосибирск, а/я 8',
                        'place'            => 'г Новосибирск',
                        'place-guid'       => '8dea00e3-9aab-4d8e-887c-ef2aaa546456',
                        'quality-code'     => 'POSTAL_BOX',
                        'region'           => 'обл Новосибирская',
                        'region-guid'      => '1ac46b49-3209-4814-b7bf-a509ea1aecd9',
                        'validation-code'  => 'VALIDATED',
                    ],
                ],
                [],
            ],
        ];

        return array_replace_recursive($this->providerAddress(), $res);
    }

}