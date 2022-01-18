<?php

namespace Tochka\Unif\Address\Contracts;

interface SourceInterface
{
    public const QUALITY_GOOD       = 'good';
    public const QUALITY_NEED_CHECK = 'need_check';

    public function __construct(array $authData);

    /**
     * Запрос в апи, обработка ошибки
     *
     * @param string $address
     * @return array|null
     */
    public function processing(string $address): ?array;

    /**
     * Обработка сырых данные, приведение к формату
     * @param array $results
     * @return array
     */
    public function resultHandler(array $results): array;
}