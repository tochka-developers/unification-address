<?php

namespace Tochka\Unif\Address\Contracts;

interface PreFilterInterface
{
    public function handle(string $address): string;
}