<?php

/*
 * BloonJPHP
 * Habbo R63 Post-Shuffle
 * Based on the work of Burak (burak@burak.fr)
 *
 * https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
 */

class GameEvents {

    public function __construct() {
        $this->initializeEvents();
    }

    private function initializeEvents() {
        EventManager::bind("GameCenterLoadGameMessageEvent");
        EventManager::bind("GameCenterJoinQueueMessageEvent");
        EventManager::bind("ClickGamesMessageEvent");
    }

    public static function ClickGamesMessageEvent(User $user, PacketParser $packet, ClassContainer $util) {
        
    }

}

new GameEvents;
