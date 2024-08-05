<?php

namespace Facilitate\Tests\Events;


use Kareem\illuminate\Facilitate\Events\Dispatcher;
use Mockery as m;
use PHPUnit\Framework\TestCase;

class EventDispatcherTest extends TestCase
{
    protected function tearDown(): void
    {
        m::close();
    }

    public function testResponseWhenNoListenersAreSet()
    {
        $d = new Dispatcher;
        $response = $d->dispatch('foo');
        $this->assertEquals([], $response);
    }
}

