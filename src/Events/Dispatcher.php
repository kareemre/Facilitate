<?php

namespace Kareem\illuminate\Facilitate\Events;

use Kareem\illuminate\Facilitate\Events\contracts\EventsInterface;
use Illuminate\Support\Facades\App;

class Dispatcher implements EventsInterface
{

    /**
     * list of registered events
     * 
     * @var array
     */
    protected $eventList = [];

    /**
     * list of classes
     * 
     * @var array
     */
    protected $classesList = [];

    /**
     * (@inheritDoc)
     */
    public function dispatch($events, ...$callbackArguments)
    {

        $responses = [];
        $events = is_string($events) ? explode(' ', $events) : $events;
        foreach ($events as $event) {

            if (! $this->hasListeners($event)) continue;

            foreach ($this->eventList[$event] as $classWithCallBack) {


                [$className, $method] = str_contains($classWithCallBack, '@') 
                                           ? $this->explodeClass($classWithCallBack)
                                           : [$classWithCallBack, 'handle'];

                if (! $this->isLoaded($className)) {
                    $this->loadClass($className);
                }

                $classInstance = $this->get($className);
                $response = $classInstance->$method(...$callbackArguments);
                if ($response === false) return false;
                $responses[] = $response;
            }
        }
        return $responses;
    }


    /**
     * Determine if a given event has listeners.
     *
     * @param  string  $eventName
     * @return bool
     */
    public function hasListeners($eventName)
    {
        return isset($this->eventList[$eventName]);
    }


    /**
     * get the instantiated class
     * 
     * @param string $className
     * @return object
     */
    protected function get(string $className)
    {
        return $this->classesList[$className];
    }


    /**
     * Determine if a given class is instantiated.
     *
     * @param  string  $className
     * @return bool
     */
    protected function isLoaded(string $className)
    {
        return isset($this->classesList[$className]);
    }


    /**
     * instantiate a given class
     * @param string $className
     * 
     * @return void
     */
    private function loadClass(string $className)
    {
        //apply exception here if not class being set
        $this->classesList[$className] = App::make($className);
    }


    /**
     * explode '@' if the listener is like classname@method
     * 
     * @param mixed $classWithCallBack
     * 
     * @return array
     */
    private function explodeClass($classWithCallBack)
    {
        return [$className, $callBack] =  explode('@', $classWithCallBack);
    }


    /**
     * (@inheritDoc)
     */
    public function subscribe($events, $eventListener)
    {

        foreach (explode(' ', $events) as $event) {

            if (! isset($eventList[$event])) {
                $this->eventList[$event] = [];
            }


            if (! in_array($eventListener, $this->eventList[$event])) {
                $this->eventList[$event][] = $eventListener;
            }
        }
    }
}
