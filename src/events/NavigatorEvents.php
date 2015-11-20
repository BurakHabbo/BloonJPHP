<?php

/*
 * BloonJPHP
 * Habbo R63 Post-Shuffle
 * Based on the work of Burak (burak@burak.fr)
 *
 * https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
 */

class NavigatorEvents {

    public function __construct() {
        $this->initializeEvents();
    }

    private function initializeEvents() {
        EventManager::bind("NavigatorGetEventsMessageEvent");
        EventManager::bind("NavigatorGetFavouriteRoomsMessageEvent");
        EventManager::bind("NavigatorGetFeaturedRoomsMessageEvent");
        EventManager::bind("NavigatorGetFriendsRoomsMessageEvent");
        EventManager::bind("NavigatorGetHighRatedRoomsMessageEvent");
        EventManager::bind("NavigatorGetMyRoomsMessageEvent");
        EventManager::bind("NavigatorGetPopularRoomsMessageEvent");
        EventManager::bind("NavigatorGetPopularTagsMessageEvent");
        EventManager::bind("NavigatorGetRecentRoomsMessageEvent");
        EventManager::bind("NavigatorSearchRoomByNameMessageEvent");
        EventManager::bind("NavigatorGetRecommendedRoomsMessageEvent");
        EventManager::bind("NavigatorGetFlatCategoriesMessageEvent");
        EventManager::bind("NavigatorGetPopularGroupsMessageEvent");
        EventManager::bind("NavigatorGetRoomsWithFriendsMessageEvent");
        EventManager::bind("NewNavigatorMessageEvent");
        EventManager::bind("SearchNewNavigatorEvent");
        EventManager::bind("NewNavigatorAddSavedSearchEvent");
        EventManager::bind("NewNavigatorDeleteSavedSearchEvent");
        EventManager::bind("NewNavigatorResizeEvent");
        EventManager::bind("NewNavigatorCollapseCategoryEvent");
        EventManager::bind("NewNavigatorUncollapseCategoryEvent");
        EventManager::bind("CanCreateRoomMessageEvent");
        EventManager::bind("CreateRoomMessageEvent");
        EventManager::bind("AddFavouriteRoomMessageEvent");
        EventManager::bind("RemoveFavouriteRoomMessageEvent");
        EventManager::bind("SetHomeRoomMessageEvent");
        EventManager::bind("GoToRoomByNameMessageEvent");
        EventManager::bind("ToggleStaffPickMessageEvent");
    }

    public static function NewNavigatorMessageEvent(User $user, PacketParser $packet, ClassContainer $util) {
        $response = new PacketConstructor();
        $response->SetHeader($util->HeaderManager->Outgoing("NavigatorMetaDataComposer"));
        $response->WriteInt32(4);
        $response->WriteString("official_view");
        $response->WriteInt32(0);
        $response->WriteString("hotel_view");
        $response->WriteInt32(0);
        $response->WriteString("roomads_view");
        $response->WriteInt32(0);
        $response->WriteString("myworld_view");
        $response->WriteInt32(0);
        $user->Send($response->Finalize());

        $response = new PacketConstructor();
        $response->SetHeader($util->HeaderManager->Outgoing("NavigatorLiftedRoomsComposer"));
        $response->WriteInt32(0);
        //foreach
        //int id
        //int 0
        //string image
        //string caption
        $user->Send($response->Finalize());

        $response = new PacketConstructor();
        $response->SetHeader($util->HeaderManager->Outgoing("NavigatorCategorys"));
        $response->WriteInt32(4 + count($util->Cache->navigatorcategories));

        foreach ($util->Cache->navigatorcategories as $flatcat) {
            $response->WriteString("category_" . $flatcat['caption']);
        }

        $response->WriteString("recommended");
        $response->WriteString("new_ads");
        $response->WriteString("staffpicks");
        $response->WriteString("official");
        $user->Send($response->Finalize());

        $response = new PacketConstructor();
        $response->SetHeader($util->HeaderManager->Outgoing("NavigatorSavedSearchesComposer"));
        $response->WriteInt32(0); //count
        //foreach
        //int id
        //string value1
        //string value2
        //string empty
        $user->Send($response->Finalize());

        $response = new PacketConstructor();
        $response->SetHeader($util->HeaderManager->Outgoing("NewNavigatorSizeMessageComposer"));
        $response->WriteInt32(10); //posX
        $response->WriteInt32(10); //posY
        $response->WriteInt32(50); //width
        $response->WriteInt32(100); //height
        $response->WriteBoolean(false); //?
        $response->WriteInt32(1);
        $user->Send($response->Finalize());
    }

    public static function NavigatorGetFlatCategoriesMessageEvent(User $user, PacketParser $packet, ClassContainer $util) {
        $response = new PacketConstructor;
        $response->SetHeader($util->HeaderManager->Outgoing("FlatCategoriesMessageComposer"));
        $response->WriteInt32(count($util->Cache->navigatorcategories));

        foreach ($util->Cache->navigatorcategories as $flatcat) {
            $response->WriteInt32($flatcat['id']);
            $response->WriteString($flatcat['caption']);
            $response->WriteBoolean($flatcat['min_rank'] <= $user->habbo['rank']);
            $response->WriteBoolean(false);
            $response->WriteString("NONE");
            $response->WriteString("");
            $response->WriteBoolean(false);
        }
        $user->Send($response->Finalize());
    }

    public static function SearchNewNavigatorEvent(User $user, PacketParser $packet, ClassContainer $util) {
        $name = $packet->readString();
        $junk = $packet->readString();

        switch ($name) {
            case "official_view":
                $navigatorlength = 2;
                break;
            case "myworld_view":
                $navigatorlength = 5;
                break;
            case "hotel_view":
            case "roomads_view":
                $navigatorlength = count($util->Cache->navigatorcategories) + 1;
                break;
            default:
                $navigatorlength = 1;
                break;
        }

        $response = new PacketConstructor;
        $response->SetHeader($util->HeaderManager->Outgoing("SearchResultSetComposer"));
        $response->WriteString($name);
        $response->WriteString($junk);
        //$response->WriteInt32(strlen($junk) > 0 ? 1 : $navigatorlength);

        if (strlen($junk) > 0) {
            $response->WriteInt32(strlen($junk) > 0 ? 1 : $navigatorlength);
            SearchResultList::SerializeSearches($junk, $response, $util);
        } else {
            $response->WriteInt32(0);
            //SearchResultList::SerializeSearchResultListStatics($name, true, $response, $util);
        }

        $user->Send($response->Finalize());
    }

}

new NavigatorEvents;
