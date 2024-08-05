<?php       
namespace Kareem\illuminate\Facilitate\Events\contracts;

interface EventsInterface
{
    /**
     * Trigger the given event(s) and pass the given arguments to any callback that
     * is listening to that event
     * Multiple events could be triggered with one method by adding space between each event
     * 
     * @return  string|array $events
     * @return  mixed ...$callbackArguments
     * @return mixed
     */
    public function dispatch(string $events, ...$callbackArguments);
    
    /**
     * Subscribe to the given event name, or in other words add event listener
     * 
     * @return  string|array $events
     * @return  string|array $callback
     * @return void
     */
    public function subscribe(string $events, $callback);
}