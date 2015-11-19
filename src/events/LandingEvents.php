<?php

/*
 * BloonJPHP
 * Habbo R63 Post-Shuffle
 * Based on the work of Burak (burak@burak.fr)
 *
 * https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
 */

use php\util\Regex;

class LandingEvents {

    public function __construct() {
        $this->initializeEvents();
    }

    private function initializeEvents() {
        EventManager::bind("LandingLoadWidgetMessageEvent");
        EventManager::bind("LandingRefreshPromosMessageEvent");
        EventManager::bind("LandingRefreshRewardMessageEvent");
        EventManager::bind("SendBadgeCampaignMessageEvent");
        EventManager::bind("LandingCommunityGoalMessageEvent");
        EventManager::bind("HotelViewCountdownMessageEvent");
        EventManager::bind("HotelViewDailyquestMessageEvent");
        EventManager::bind("HotelViewRequestBadgeMessageEvent");
        EventManager::bind("GetHotelViewHallOfFameMessageEvent");
    }

    public static function LandingLoadWidgetMessageEvent(User $user, PacketParser $packet, ClassContainer $util) {
        $widget = $packet->readString();

        $response = new PacketConstructor;
        $response->SetHeader($util->HeaderManager->Outgoing("LandingWidgetMessageComposer"));

        if (isset($widget) && $widget != "") {
            $eventData = explode(",", $widget);

            if (Regex::match("/gamesmaker/i", $eventData[1])) {
                return;
            }

            $response->WriteString($widget);
            $response->WriteString($eventData[1]);
        } else {
            $response->WriteString("");
            $response->WriteString("");
        }
        $user->Send($response->Finalize());
    }

    public static function LandingRefreshPromosMessageEvent(User $user, PacketParser $packet, ClassContainer $util) {
        $response = new PacketConstructor;
        $response->SetHeader($util->HeaderManager->Outgoing("LandingPromosMessageComposer"));
        $response->WriteInt32(count($util->Cache->hotelviewpromos));

        foreach ($util->Cache->hotelviewpromos as $promo) {
            $response->WriteInt32($promo['index']);
            $response->WriteString($promo['header']);
            $response->WriteString($promo['body']);
            $response->WriteString($promo['button']);
            $response->WriteInt32($promo['in_game_promo']);
            $response->WriteString($promo['special_action']);
            $response->WriteString($promo['image']);
        }
        $user->Send($response->Finalize());
    }

    public static function LandingRefreshRewardMessageEvent(User $user, PacketParser $packet, ClassContainer $util) {
        $promo = $util->Cache->hotelviewrewardpromo[0];

        if ($promo['enabled'] == "1") {
            $response = new PacketConstructor;
            $response->SetHeader($util->HeaderManager->Outgoing("LandingRewardMessageComposer"));
            $response->WriteString($promo['furni_name']);
            $response->WriteInt32($promo['furni_id']);
            $response->WriteInt32(120);
            $response->WriteInt32(120 - ($user->habbo['respect']));
            $user->Send($response->Finalize());
        }
    }

}

new LandingEvents;
