<?php

/*
 * BloonJPHP
 * Habbo R63 Post-Shuffle
 * Based on the work of Burak (burak@burak.fr)
 *
 * https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
 */

class RoomManager {

    private $rooms = array();
    private $database;

    public function __construct(Database $database) {
        $this->database = $database;
    }

    public function getRoom($id) {
        return isset($this->rooms[$id]) ? $this->rooms[$id] : self::loadRoom($id);
    }

    private function loadRoom($id) {
        return $this->rooms[$id] = new Room($id, $this->database);
    }

    private function unloadRoom($id) {
        unset($this->rooms[$id]);
    }

    public function countActiveRooms() {
        return count($this->rooms);
    }

    public function getActiveRooms() {
        return $this->rooms;
    }

    public function onCycle() {
        foreach ($this->$rooms as $room) {
            if ($room->getUsersNow() <= 0)
                $this->unloadRoom($room->getId());
        }
    }

}
