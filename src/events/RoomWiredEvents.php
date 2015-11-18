<?php
/*
* BloonJPHP
* Habbo R63 Post-Shuffle
* Based on the work of Burak (burak@burak.fr)
*
* https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
*/

class RoomWiredEvents {

    public function __construct() {
        $this->initializeEvents();
    }

    private function initializeEvents() {
        EventManager::bind("WiredSaveConditionMessageEvent");
        EventManager::bind("WiredSaveEffectMessageEvent");
        EventManager::bind("WiredSaveMatchingMessageEvent");
        EventManager::bind("WiredSaveTriggerMessageEvent");
    }

}

new RoomWiredEvents;
