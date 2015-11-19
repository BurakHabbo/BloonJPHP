<?php

/*
 * BloonJPHP
 * Habbo R63 Post-Shuffle
 * Based on the work of Burak (burak@burak.fr)
 *
 * https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
 */

class HabboEvents {

    public function __construct() {
        $this->initializeEvents();
    }

    private function initializeEvents() {
        EventManager::bind("InfoRetrieveMessageEvent");
        EventManager::bind("GetCurrencyBalanceMessageEvent");
        EventManager::bind("GetSubscriptionDataMessageEvent");
        EventManager::bind("OnlineConfirmationMessageEvent");
        EventManager::bind("RequestLatencyTestMessageEvent");
        EventManager::bind("UserGetVolumeSettingsMessageEvent");
        EventManager::bind("SaveClientSettingsMessageEvent");
        EventManager::bind("GetTalentsTrackMessageEvent");
        EventManager::bind("LoadUserProfileMessageEvent");
        EventManager::bind("RelationshipsGetMessageEvent");
        EventManager::bind("SetRelationshipMessageEvent");
        EventManager::bind("GetUserBadgesMessageEvent");
        EventManager::bind("GetUserTagsMessageEvent");
        EventManager::bind("OnDisconnectMessageEvent");
        EventManager::bind("GoToHotelViewMessageEvent");
        EventManager::bind("UserUpdateLookMessageEvent");
        EventManager::bind("UserUpdateMottoMessageEvent");
        EventManager::bind("CheckUsernameMessageEvent");
        EventManager::bind("ChangeUsernameMessageEvent");
        EventManager::bind("WardrobeMessageEvent");
        EventManager::bind("WardrobeUpdateMessageEvent");
    }

    public static function InfoRetrieveMessageEvent(User $user, PacketParser $packet, ClassContainer $util) {
        $response = new PacketConstructor;
        $response->SetHeader($util->HeaderManager->Outgoing("UserObjectMessageComposer"));
        $response->WriteInt32($user->habbo['id']);
        $response->WriteString($user->habbo['username']);
        $response->WriteString($user->habbo['look']);
        $response->WriteString(strtoupper($user->habbo['gender']));
        $response->WriteString($user->habbo['motto']);
        $response->WriteString("");
        $response->WriteBoolean(false);
        $response->WriteInt32($user->habbo['respect']);
        $response->WriteInt32($user->habbo['daily_respect_points']);
        $response->WriteInt32($user->habbo['daily_pet_respect_points']);
        $response->WriteBoolean(true);
        // $response->WriteString($user->habbo->last_online);
        $response->WriteString("11-11-2012 14:46:41");
        $response->WriteBoolean(false); //can change name ?
        $response->WriteBoolean(false);
        $user->Send($response->Finalize());

        $response = new PacketConstructor;
        $response->SetHeader($util->HeaderManager->Outgoing("BuildersClubMembershipMessageComposer"));
        $response->WriteInt32(60 * 60 * 24 * 30 * 12);
        $response->WriteInt32(10000);
        $response->WriteInt32(1);
        $user->Send($response->Finalize());

        $response = new PacketConstructor;
        $response->SetHeader($util->HeaderManager->Outgoing("SendPerkAllowancesMessageComposer"));
        $response->WriteInt32(11);

        $response->WriteString("BUILDER_AT_WORK");
        $response->WriteString("");
        $response->WriteBoolean(true); //canUseFloorEditor?

        $response->WriteString("VOTE_IN_COMPETITIONS");
        $response->WriteString("requirement.unfulfilled.helper_level_2");
        $response->WriteBoolean(false);

        $response->WriteString("USE_GUIDE_TOOL");
        $response->WriteString("");
        $response->WriteBoolean(true);

        $response->WriteString("JUDGE_CHAT_REVIEWS");
        $response->WriteString("requirement.unfulfilled.helper_level_6");
        $response->WriteBoolean(false);

        $response->WriteString("NAVIGATOR_ROOM_THUMBNAIL_CAMERA");
        $response->WriteString("");
        $response->WriteBoolean(true);

        $response->WriteString("CALL_ON_HELPERS");
        $response->WriteString("");
        $response->WriteBoolean(true);

        $response->WriteString("CITIZEN");
        $response->WriteString("");
        $response->WriteBoolean(true);

        $response->WriteString("MOUSE_ZOOM");
        $response->WriteString("");
        $response->WriteBoolean(false);

        $response->WriteString("TRADE");
        $response->WriteString(""); //tradeLocked ? "" : "requirement.unfulfilled.no_trade_lock"
        $response->WriteBoolean(true);

        $response->WriteString("CAMERA");
        $response->WriteString("");
        $response->WriteBoolean(true);

        $response->WriteString("NAVIGATOR_PHASE_TWO_2014");
        $response->WriteString("");
        $response->WriteBoolean(true);

        $user->Send($response->Finalize());
    }

    public static function GetCurrencyBalanceMessageEvent(User $user, PacketParser $packet, ClassContainer $util) {
        $user->UpdateCreditsBalance($util);
        $user->UpdateSeasonalCurrencyBalance($util);
    }

    public static function GetSubscriptionDataMessageEvent(User $user, PacketParser $packet, ClassContainer $util) {
        $response = new PacketConstructor;
        $response->SetHeader($util->HeaderManager->Outgoing("SubscriptionStatusMessageComposer"));
        $response->WriteString("club_habbo");
        $response->WriteInt32(31);
        $response->WriteInt32(1);
        $response->WriteInt32(1);
        $response->WriteInt32(1);
        $response->WriteBoolean(true);
        $response->WriteBoolean(true);
        $response->WriteInt32(0);
        $response->WriteInt32(31);
        $response->WriteInt32(495);
        $user->Send($response->Finalize());

        $response = new PacketConstructor;
        $response->SetHeader($util->HeaderManager->Outgoing("UserClubRightsMessageComposer"));
        $response->WriteInt32(2);
        $response->WriteInt32($user->habbo['rank']);
        $response->WriteInt32(0);
        $user->Send($response->Finalize());
    }

    public static function UserGetVolumeSettingsMessageEvent(User $user, PacketParser $packet, ClassContainer $util) {
        $response = new PacketConstructor;
        $response->SetHeader($util->HeaderManager->Outgoing("LoadVolumeMessageComposer"));
        $response->WriteInt32($user->habbo['volume']);
        $response->WriteInt32($user->habbo['volume']);
        $response->WriteInt32($user->habbo['volume']);
        $response->WriteBoolean(false); //old chat
        $response->WriteBoolean(false); //ignore room invite
        $response->WriteBoolean(false); //disable camera follow
        $response->WriteInt32(3); //collapse friends (3 = no)
        $response->WriteInt32(0); //bubble
        $user->Send($response->Finalize());
    }

    public static function OnlineConfirmationMessageEvent(User $user, PacketParser $packet, ClassContainer $util) {
        
    }

}

new HabboEvents;
