<?php

class MyEvent
{
    public $event_base;

    public $events = [];

    public function __construct()
    {
        $this->event_base = new EventBase();
    }

    public function add($fd, $what, $callback, $callback_arg)
    {
        $event = new Event($this->event_base, $fd, $what, $callback, $callback_arg);

        $this->events[intval($fd)] = $event;

        $event->add();
    }

    public function remove($fd)
    {
        $event = $this->events[intval($fd)];
        $event->free();
    }

    public function loop()
    {
        $this->event_base->loop();
    }
}
