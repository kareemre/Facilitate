<?php

namespace Kareem\illuminate\Facilitate\Events;

use App\Events\contracts\EventsInterface;
use Illuminate\Support\Facades\App;

class Events implements EventsInterface
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
    public function trigger($events, ...$callbackArguments)
    {
        $events = is_string($events) ? explode(' ', $events) : $events;

        foreach ($events as $event) {

            if (! isset($this->eventList[$event])) continue;

            foreach ($this->eventList[$event] as $classWithCallBack) {

                if (str_contains($classWithCallBack, '@')) {

                    [$className, $callBack] = $this->explodeClass($classWithCallBack);
                } else {

                    [$className, $callBack] = [$classWithCallBack, 'handle'];
                }

                if (!$this->isLoaded($className)) {
                    $this->loadClass($className);
                }

                $classInstance = $this->get($className);
                 
            }
        }
    }


    protected function get(string $className)
    {
        return $this->classesList[$className];
    }


    protected function isLoaded(string $className)
    {
        return isset($this->classesList[$className]);
    }


    private function loadClass(string $className)
    {
        //apply exception here if not class being set
        $this->classesList[$className] = App::make($className);
    }


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

            if (is_array($eventListener)) {

                $listenersImploded[] = implode('@', $eventListener);
            }

            if (! in_array($eventListener, $this->eventList[$event])) {
                $this->eventList[$event][] = $eventListener;
            }
        }
    }
}


