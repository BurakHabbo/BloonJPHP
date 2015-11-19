<?php

/*
 * BloonJPHP
 * Habbo R63 Post-Shuffle
 * Based on the work of Burak (burak@burak.fr)
 *
 * https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
 */

class ModerationToolEvents {

    public function __construct() {
        $this->initializeEvents();
    }

    private function initializeEvents() {
        EventManager::bind("ModerationToolUserToolMessageEvent");
        EventManager::bind("ModerationToolRoomChatlogMessageEvent");
        EventManager::bind("ModerationToolRoomToolMessageEvent");
        EventManager::bind("ModerationBanUserMessageEvent");
        EventManager::bind("ModerationKickUserMessageEvent");
        EventManager::bind("ModerationMuteUserMessageEvent");
        EventManager::bind("ModerationLockTradeMessageEvent");
        EventManager::bind("ModerationToolCloseIssueMessageEvent");
        EventManager::bind("ModerationToolGetRoomVisitsMessageEvent");
        EventManager::bind("ModerationToolPerformRoomActionMessageEvent");
        EventManager::bind("ModerationToolPickIssueMessageEvent");
        EventManager::bind("ModerationToolReleaseIssueMessageEvent");
        EventManager::bind("ModerationToolSendRoomAlertMessageEvent");
        EventManager::bind("ModerationToolSendUserAlertMessageEvent");
        EventManager::bind("ModerationToolSendUserCautionMessageEvent");
        EventManager::bind("ModerationToolUserChatlogMessageEvent");
        EventManager::bind("ModerationToolIssueChatlogMessageEvent");
        EventManager::bind("AmbassadorAlertMessageEvent");
        EventManager::bind("GetUCPanelMessageEvent");
        EventManager::bind("GetUCPanelHotelMessageEvent");
        EventManager::bind("DeleteHelpTicketMessageEvent");
    }

}

new ModerationToolEvents;
