<?php
/*
* BloonJPHP
* Habbo R63 Post-Shuffle
* Based on the work of Burak (burak@burak.fr)
*
* https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
*/

class FriendEvents {

    public function __construct() {
        $this->initializeEvents();
    }

    private function initializeEvents() {
        EventManager::bind("ConsoleInstantChatMessageEvent");
        EventManager::bind("ConsoleInviteFriendsMessageEvent");
        EventManager::bind("ConsoleSearchFriendsMessageEvent");
        EventManager::bind("FollowFriendMessageEvent");
        EventManager::bind("FriendListUpdateMessageEvent");
        EventManager::bind("FriendRequestListLoadEvent");
        EventManager::bind("AcceptFriendMessageEvent");
        EventManager::bind("DeclineFriendMessageEvent");
        EventManager::bind("DeleteFriendMessageEvent");
        EventManager::bind("RequestFriendMessageEvent");
        EventManager::bind("GetMyFriendsMessageEvent");
        EventManager::bind("FindMoreFriendsMessageEvent");
        EventManager::bind("ConsoleInitEvent");
    }

    public static function GetMyFriendsMessageEvent(User $user, PacketParser $packet, ClassContainer $util) {
        
    }

    public static function ConsoleInitEvent(User $user, PacketParser $packet, ClassContainer $util) {
        $response = new PacketConstructor;
        $response->SetHeader($util->HeaderManager->Outgoing("LoadFriendsCategories"));
        $response->WriteInt32(2000);
        $response->WriteInt32(300);
        $response->WriteInt32(800);
        $response->WriteInt32(1100);
        $response->WriteInt32(0); //count
        //int id
        //str name

        $user->Send($response->Finalize());

        $friends = $util->Database->Query("SELECT u.id,u.username,u.look,u.online,u.motto FROM messenger_friendships m, users u WHERE m.user_one_id = ? AND u.id = m.user_two_id ORDER BY online DESC", array($user->habbo['id']));

        $response = new PacketConstructor;
        $response->SetHeader($util->HeaderManager->Outgoing("LoadFriendsMessageComposer"));
        $response->WriteInt32(1);
        $response->WriteInt32(0);
        $response->WriteInt32(count($friends));

        foreach ($friends as $friend) {
            $response->WriteInt32($friend['id']);
            $response->WriteString($friend['username']);
            $response->WriteInt32($friend['online']);
            $response->WriteBoolean(false);
            $response->WriteBoolean(false);
            $response->WriteString($friend['look']);
            $response->WriteInt32(0);
            $response->WriteString($friend['motto']);
            $response->WriteString("");
            $response->WriteString("");
            $response->WriteBoolean(true); //persistedMessageUser
            $response->WriteBoolean(false);
            $response->WriteBoolean(false); //pockethabbo ?
            $response->WriteInt16(0); //relationship
        }

        $user->Send($response->Finalize());
    }

    public static function FriendRequestListLoadEvent(User $user, PacketParser $packet, ClassContainer $util) {
        
    }

}

new FriendEvents;
