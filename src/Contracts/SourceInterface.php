<?php

namespace Tochka\Unif\Address\Contracts;

interface SourceInterface
{
    public const QUALITY_GOOD       = 'good';
    public const QUALITY_NEED_CHECK = 'need_check';

    public function __construct(array $authData);

    public function processing(string $address): array;

    public function resultHandler(array $results): array;
}