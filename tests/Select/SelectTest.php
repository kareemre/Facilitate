<?php

namespace Facilitate\Tests\Select;


use Kareem\illuminate\Facilitate\Repository\Select;
use Mockery as m;
//use PHPUnit\Framework\TestCase;
 use Orchestra\Testbench\TestCase;
class SelectTest extends TestCase
{
    protected function tearDown(): void
    {
        m::close();
    }



    public function testAddMethodExecution()
    {
        $s = new Select(['1', '2', '3']);
        $response = $s->add('4', '5');
        $this->assertEquals(['1', '2', '3', '4', '5'], $response);
    }
}


