<?php

namespace Tochka\Unif\Address\Tests\Sources;

class DaData extends AbstractSource
{

    /**
     * @testdox      resultHandler address
     *
     * @dataProvider providerAddress
     *
     * @param $in
     * @param $out
     */
    public function testAddress($in, $out): void
    {
        $this->assertEquals($out, (new \Tochka\Unif\Address\Sources\DaData([]))->resultHandler($in));
    }

}