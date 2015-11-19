<?php

/*
 * BloonJPHP
 * Habbo R63 Post-Shuffle
 * Based on the work of Burak (burak@burak.fr)
 *
 * https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
 */

class RoomItemEvents {

    public function __construct() {
        $this->initializeEvents();
    }

    private function initializeEvents() {
        EventManager::bind("ToggleSittingMessageEvent");
        EventManager::bind("RoomAddFloorItemMessageEvent");
        EventManager::bind("PlaceBuildersWallItemMessageEvent");
        EventManager::bind("FloorItemMoveMessageEvent");
        EventManager::bind("WallItemMoveMessageEvent");
        EventManager::bind("TriggerDiceCloseMessageEvent");
        EventManager::bind("TriggerDiceRollMessageEvent");
        EventManager::bind("TriggerItemMessageEvent");
        EventManager::bind("TriggerMoodlightMessageEvent");
        EventManager::bind("TriggerWallItemMessageEvent");
        EventManager::bind("EnterOneWayDoorMessageEvent");
        EventManager::bind("UpdateMoodlightMessageEvent");
        EventManager::bind("OpenPostItMessageEvent");
        EventManager::bind("RoomAddPostItMessageEvent");
        EventManager::bind("SavePostItMessageEvent");
        EventManager::bind("UseHabboWheelMessageEvent");
        EventManager::bind("ActivateMoodlightMessageEvent");
        EventManager::bind("RoomApplySpaceMessageEvent");
        EventManager::bind("SaveFootballGateOutfitMessageEvent");
        EventManager::bind("YouTubeChoosePlaylistVideoMessageEvent");
        EventManager::bind("YouTubeGetPlayerMessageEvent");
        EventManager::bind("YouTubeGetPlaylistGetMessageEvent");
        EventManager::bind("TileStackMagicSetHeightMessageEvent");
        EventManager::bind("SaveRoomBackgroundTonerMessageEvent");
        EventManager::bind("SaveRoomBrandingMessageEvent");
        EventManager::bind("MannequinSaveDataMessageEvent");
        EventManager::bind("MannequinUpdateDataMessageEvent");
        EventManager::bind("LoadJukeboxDiscsMessageEvent");
        EventManager::bind("JukeboxAddPlaylistItemMessageEvent");
        EventManager::bind("JukeboxRemoveSongMessageEvent");
        EventManager::bind("GetJukeboxPlaylistsMessageEvent");
        EventManager::bind("GetMusicDataMessageEvent");
        EventManager::bind("OpenGiftMessageEvent");
        EventManager::bind("ReedemExchangeItemMessageEvent");
        EventManager::bind("RemovePostItMessageEvent");
        EventManager::bind("ConfirmLoveLockMessageEvent");
        EventManager::bind("UsePurchasableClothingMessageEvent");
    }

}

new RoomItemEvents;
