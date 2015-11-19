<?php

/*
 * BloonJPHP
 * Habbo R63 Post-Shuffle
 * Based on the work of Burak (burak@burak.fr)
 *
 * https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
 */

class OtherEvents {

    public function __construct() {
        $this->initializeEvents();
    }

    private function initializeEvents() {
        EventManager::bind("PongMessageEvent");
        EventManager::bind("RetrieveCitizenshipStatusEvent");
        EventManager::bind("NuxAcceptGiftsMessageEvent");
        EventManager::bind("NuxReceiveGiftsMessageEvent");
        EventManager::bind("HabboCameraMessageEvent");
        EventManager::bind("HabboCameraPublishPhotoEvent");
        EventManager::bind("GetCameraPriceMessageEvent");
    }

    public static function RetrieveCitizenshipStatusEvent(User $user, PacketParser $packet, ClassContainer $util) {
        $response = new PacketConstructor;
        $response->SetHeader($util->HeaderManager->Outgoing("CitizenshipStatusMessageComposer"));
        $response->WriteString($packet->readString());
        $response->WriteInt32(4);
        $response->WriteInt32(4);
        $user->Send($response->Finalize());
    }

}

new OtherEvents;
