<?php

/*
 * BloonJPHP
 * Habbo R63 Post-Shuffle
 * Based on the work of Burak (burak@burak.fr)
 *
 * https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
 */

class GroupEvents {

    public function __construct() {
        $this->initializeEvents();
    }

    private function initializeEvents() {
        EventManager::bind("GetGroupForumsMessageEvent");
        EventManager::bind("GetGroupForumDataMessageEvent");
        EventManager::bind("GetGroupForumThreadRootMessageEvent");
        EventManager::bind("UpdateThreadMessageEvent");
        EventManager::bind("UpdateForumSettingsMessageEvent");
        EventManager::bind("AlterForumThreadStateMessageEvent");
        EventManager::bind("PublishForumThreadMessageEvent");
        EventManager::bind("ReadForumThreadMessageEvent");
        EventManager::bind("RequestLeaveGroupMessageEvent");
        EventManager::bind("ConfirmLeaveGroupMessageEvent");
        EventManager::bind("AcceptGroupRequestMessageEvent");
        EventManager::bind("CreateGuildMessageEvent");
        EventManager::bind("GetGroupFurnitureMessageEvent");
        EventManager::bind("GetGroupInfoMessageEvent");
        EventManager::bind("GetGroupMembersMessageEvent");
        EventManager::bind("GetGroupPurchaseBoxMessageEvent");
        EventManager::bind("GetGroupPurchasingInfoMessageEvent");
        EventManager::bind("GroupDeclineMembershipRequestMessageEvent");
        EventManager::bind("GroupMakeAdministratorMessageEvent");
        EventManager::bind("GroupManageMessageEvent");
        EventManager::bind("GroupUpdateBadgeMessageEvent");
        EventManager::bind("GroupUpdateColoursMessageEvent");
        EventManager::bind("GroupUpdateNameMessageEvent");
        EventManager::bind("GroupUpdateSettingsMessageEvent");
        EventManager::bind("GroupUserJoinMessageEvent");
        EventManager::bind("SetFavoriteGroupMessageEvent");
        EventManager::bind("RemoveFavouriteGroupMessageEvent");
        EventManager::bind("RemoveGroupAdminMessageEvent");
        EventManager::bind("DeleteGroupMessageEvent");
    }

}

new GroupEvents;
