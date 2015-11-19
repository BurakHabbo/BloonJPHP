<?php

/*
 * BloonJPHP
 * Habbo R63 Post-Shuffle
 * Based on the work of Burak (burak@burak.fr)
 *
 * https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
 */

class UserRoomEvents {

    public function __construct() {
        $this->initializeEvents();
    }

    private function initializeEvents() {
        EventManager::bind("ChatMessageEvent");
        EventManager::bind("ShoutMessageEvent");
        EventManager::bind("UserWhisperMessageEvent");
        EventManager::bind("UserWalkMessageEvent");
        EventManager::bind("UserDanceMessageEvent");
        EventManager::bind("UserSignMessageEvent");
        EventManager::bind("RoomBanUserMessageEvent");
        EventManager::bind("RoomUnbanUserMessageEvent");
        EventManager::bind("RoomKickUserMessageEvent");
        EventManager::bind("RateRoomMessageEvent");
        EventManager::bind("DropHanditemMessageEvent");
        EventManager::bind("GiveHanditemMessageEvent");
        EventManager::bind("GiveRespectMessageEvent");
        EventManager::bind("GiveRightsMessageEvent");
        EventManager::bind("StartTypingMessageEvent");
        EventManager::bind("StopTypingMessageEvent");
        EventManager::bind("IgnoreUserMessageEvent");
        EventManager::bind("UnignoreUserMessageEvent");
        EventManager::bind("LookAtUserMessageEvent");
        EventManager::bind("TradeAcceptMessageEvent");
        EventManager::bind("TradeAddItemOfferMessageEvent");
        EventManager::bind("TradeCancelMessageEvent");
        EventManager::bind("TradeConfirmMessageEvent");
        EventManager::bind("TradeDiscardMessageEvent");
        EventManager::bind("TradeRemoveItemMessageEvent");
        EventManager::bind("TradeStartMessageEvent");
        EventManager::bind("TradeUnacceptMessageEvent");
        EventManager::bind("SetChatPreferenceMessageComposer");
        EventManager::bind("SetRoomCameraPreferencesMessageComposer");
    }

}

new UserRoomEvents;
