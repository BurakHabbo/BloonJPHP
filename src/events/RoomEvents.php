<?php

/*
 * BloonJPHP
 * Habbo R63 Post-Shuffle
 * Based on the work of Burak (burak@burak.fr)
 *
 * https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
 */

class RoomEvents {

    public function __construct() {
        $this->initializeEvents();
    }

    private function initializeEvents() {
        EventManager::bind("EnterPrivateRoomMessageEvent");
        EventManager::bind("RoomGetHeightmapMessageEvent");
        EventManager::bind("RoomGetInfoMessageEvent");
        EventManager::bind("RoomUserActionMessageEvent");
        EventManager::bind("RoomOnLoadMessageEvent");
        EventManager::bind("RoomDeleteMessageEvent");
        EventManager::bind("RoomEventUpdateMessageEvent");
        EventManager::bind("RoomGetSettingsInfoMessageEvent");
        EventManager::bind("RoomSaveSettingsMessageEvent");
        EventManager::bind("RoomSettingsMuteAllMessageEvent");
        EventManager::bind("RoomSettingsMuteUserMessageEvent");
        EventManager::bind("RoomLoadByDoorbellMessageEvent");
        EventManager::bind("DoorbellAnswerMessageEvent");
        EventManager::bind("RoomGetFilterMessageEvent");
        EventManager::bind("RoomAlterFilterMessageEvent");
        EventManager::bind("GetRoomBannedUsersMessageEvent");
        EventManager::bind("GetRoomRightsListMessageEvent");
        EventManager::bind("RoomRemoveAllRightsMessageEvent");
        EventManager::bind("RoomRemoveUserRightsMessageEvent");
        EventManager::bind("GetFloorPlanFurnitureMessageEvent");
        EventManager::bind("GetFloorPlanDoorMessageEvent");
        EventManager::bind("SaveFloorPlanEditorMessageEvent");
        EventManager::bind("SaveRoomThumbnailMessageEvent");
        EventManager::bind("SetInvitationsPreferenceMessageEvent");
        EventManager::bind("SubmitRoomToCompetitionMessageEvent");
        EventManager::bind("VoteForRoomMessageEvent");
    }

    public static function EnterPrivateRoomMessageEvent(User $user, PacketParser $packet, ClassContainer $util) {
        $id = $packet->readInt32();
        $password = $packet->readString();

        $util->RoomManager->PrepareRoomForUser($user, $util, $id, $password);
    }

    public static function RoomGetInfoMessageEvent(User $user, PacketParser $packet, ClassContainer $util) {
        $id = $packet->readInt32();
        $num = $packet->readInt32();
        $num2 = $packet->readInt32();

        $room = $util->RoomManager->getRoom($id);

        if ($num == 0 && $num2 == 1) {
            $room->SerializeRoomInformation(false, $util, $user);
            return;
        } else if ($num == 0 && $num2 == 0) {
            $room->SerializeRoomInformation(true, $util, $user);
            return;
        }

        $room->SerializeRoomInformation(true, $util, $user);
    }

}

new RoomEvents;
