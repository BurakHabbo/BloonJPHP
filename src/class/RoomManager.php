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

    public function PrepareRoomForUser(User $user, ClassContainer $util, $id, $password, $isReload = false) {
        if ($user->loadingRoom == $id || !is_array($user->habbo))
            return;
        $user->loadingRoom = $id;

        if ($user->inRoom) {
            //remove user from current room here
            $user->currentRoom->leave();
        }

        $room = $util->RoomManager->getRoom($id);

        //if ($room == 0)
        //return;

        if ($room->getUsersNow() >= $room->getUsersMax() && $user->habbo['id'] != $room->owner['id']) {
            $response = new PacketConstructor;
            $response->SetHeader($util->HeaderManager->Outgoing("RoomEnterErrorMessageComposer"));
            $response->WriteInt32(1);
            $user->Send($response->Finalize());

            $response = new PacketConstructor;
            $response->SetHeader($util->HeaderManager->Outgoing("OutOfRoomMessageComposer"));
            $user->Send($response->Finalize());

            $user->loadingRoom = 0;
            $user->loadingChecksPassed = false;
            return;
        }

        $user->currentLoadingRoom = $room;

        //check room ban here

        $response = new PacketConstructor;
        $response->SetHeader($util->HeaderManager->Outgoing("PrepareRoomMessageComposer"));
        $user->Send($response->Finalize());

        $user->loadingChecksPassed = true;

        $this->LoadRoomForUser($user, $util);
    }

    public static function LoadRoomForUser(User $user, ClassContainer $util) {
        $room = $user->currentLoadingRoom;

        $response = new PacketConstructor;
        $response->SetHeader($util->HeaderManager->Outgoing("RoomGroupMessageComposer"));
        $response->WriteInt32(0); //count
        //id
        //string
        $user->Send($response->Finalize());

        $response = new PacketConstructor;
        $response->SetHeader($util->HeaderManager->Outgoing("InitialRoomInfoMessageComposer"));
        $response->WriteString($room->getModelName());
        $response->WriteInt32($room->getId());
        $user->Send($response->Finalize());

        if ($user->spectatorMode) {
            $response = new PacketConstructor;
            $response->SetHeader($util->HeaderManager->Outgoing("SpectatorModeMessageComposer"));
            $user->Send($response->Finalize());
        }

        if ($room->getWallpaper() != "0.0") {
            $response = new PacketConstructor;
            $response->SetHeader($util->HeaderManager->Outgoing("RoomSpacesMessageComposer"));
            $response->WriteString("wallpaper");
            $response->WriteString($room->getWallpaper());
            $user->Send($response->Finalize());
        }

        if ($room->getFloor() != "0.0") {
            $response = new PacketConstructor;
            $response->SetHeader($util->HeaderManager->Outgoing("RoomSpacesMessageComposer"));
            $response->WriteString("floor");
            $response->WriteString($room->getFloor());
            $user->Send($response->Finalize());
        }

        $response = new PacketConstructor;
        $response->SetHeader($util->HeaderManager->Outgoing("RoomSpacesMessageComposer"));
        $response->WriteString("landscape");
        $response->WriteString($room->getLandscape());
        $user->Send($response->Finalize());

        //owner rights, TODO: check rights
        $response = new PacketConstructor;
        $response->SetHeader($util->HeaderManager->Outgoing("RoomRightsLevelMessageComposer"));
        $response->WriteInt32(4);
        $user->Send($response->Finalize());

        $response = new PacketConstructor;
        $response->SetHeader($util->HeaderManager->Outgoing("HasOwnerRightsMessageComposer"));
        $user->Send($response->Finalize());

        $response = new PacketConstructor;
        $response->SetHeader($util->HeaderManager->Outgoing("RoomRatingMessageComposer"));
        $response->WriteInt32($room->getScore());
        $response->WriteBoolean(false); //can vote ?
        $user->Send($response->Finalize());

        $response = new PacketConstructor;
        $response->SetHeader($util->HeaderManager->Outgoing("RoomUpdateMessageComposer"));
        $response->WriteInt32($room->getId());
        $user->Send($response->Finalize());
    }

}
