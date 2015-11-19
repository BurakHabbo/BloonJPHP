<?php

/*
 * BloonJPHP
 * Habbo R63 Post-Shuffle
 * Based on the work of Burak (burak@burak.fr)
 *
 * https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
 */

class EventManager {

    public static function bind($event) {
        global $events, $headermanager;

        $class = debug_backtrace()[1]['class'];

        if (method_exists($class, $event)) {
            $events[$headermanager->Incoming($event)] = Util::EventMethod($class, $event);
        }
    }

}
