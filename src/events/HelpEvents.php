<?php
/*
* BloonJPHP
* Habbo R63 Post-Shuffle
* Based on the work of Burak (burak@burak.fr)
*
* https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
*/

class HelpEvents {

    public function __construct() {
        $this->initializeEvents();
    }

    private function initializeEvents() {
        EventManager::bind("SubmitHelpTicketMessageEvent");
        EventManager::bind("OpenBullyReportingMessageEvent");
        EventManager::bind("SendBullyReportMessageEvent");
        EventManager::bind("OpenHelpToolMessageEvent");
        EventManager::bind("OnGuideSessionDetachedMessageEvent");
        EventManager::bind("GetHelperToolConfigurationMessageEvent");
        EventManager::bind("OnGuideMessageEvent");
        EventManager::bind("GuideToolMessageNew");
        EventManager::bind("GuideInviteToRoom");
        EventManager::bind("VisitRoomGuides");
        EventManager::bind("GuideEndSession");
        EventManager::bind("CancellInviteGuide");
    }

}

new HelpEvents;
