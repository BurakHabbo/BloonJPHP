<?php

/*
 * BloonJPHP
 * Habbo R63 Post-Shuffle
 * Based on the work of Burak (burak@burak.fr)
 *
 * https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
 */

use php\lib\String;
use php\io\File;

Class Autoloader {

    private $class = array();
    private $events = array();

    public function __construct() {
        $classFiles = new File('./src/class/');

        foreach ($classFiles->findFiles() as $classFile) {
            $this->class[] = String::replace($classFile->getName(), ".php", "");
        }

        $eventsFiles = new File('./src/events/');

        foreach ($eventsFiles->findFiles() as $eventsFile) {
            $this->events[] = String::replace($eventsFile->getName(), ".php", "");
        }
    }

    public function loadClass() {
        foreach ($this->class as $class) {
            require('res://class/' . $class . '.php');
        }
    }

    public function loadEvents() {
        foreach ($this->events as $events) {
            require('res://events/' . $events . '.php');
        }
    }

    public function getClassArray() {
        return $this->class;
    }

    public function getEventsArray() {
        return $this->events;
    }

}
