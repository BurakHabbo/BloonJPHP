<?php
/*
* BloonJPHP
* Habbo R63 Post-Shuffle
* Based on the work of Burak (burak@burak.fr)
*
* https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
*/

class InventoryEvents {

    public function __construct() {
        $this->initializeEvents();
    }

    private function initializeEvents() {
        EventManager::bind("LoadPetInventoryMessageEvent");
        EventManager::bind("LoadBotInventoryMessageEvent");
        EventManager::bind("LoadBadgeInventoryMessageEvent");
        EventManager::bind("LoadItemsInventoryMessageEvent");
        EventManager::bind("SetActivatedBadgesMessageEvent");
        EventManager::bind("EnableInventoryEffectMessageEvent");
        EventManager::bind("EffectEnableMessageEvent");
    }

}

new InventoryEvents;
