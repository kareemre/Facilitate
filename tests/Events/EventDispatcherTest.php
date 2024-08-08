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

    public function testBasicEventExecution()
    {
        $d = new Dispatcher();
        $d->subscribe('foo', TestEventListener::class);
        $response = $d->dispatch('foo', ['foo', 'bar']);
        $this->assertEquals(['baz'], $response);
    }
}

class TestEventListener
{
    public function handle($foo, $bar)
    {
        return 'baz';
    }
    
    //this method will be called if listener is like 
    //listener::class@method
    public function onFooEvent($foo, $bar)
    {
        return 'baz';
    }
}

