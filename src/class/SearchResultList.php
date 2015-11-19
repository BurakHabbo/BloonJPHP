<?php

/*
 * BloonJPHP
 * Habbo R63 Post-Shuffle
 * Based on the work of Burak (burak@burak.fr)
 *
 * https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
 */

use php\lib\String;

class SearchResultList {

    public static function SerializeSearches($searchQuery, PacketConstructor $response, ClassContainer $util) {
        $response->WriteString("");
        $response->WriteString($searchQuery);
        $response->WriteInt32(2);
        $response->WriteBoolean(false);
        $response->WriteInt32(0);

        $containsOwner = false;
        $containsGroup = false;

        //TODO: check owner: or group:, replace boolean, remove tags from searchQuery

        $rooms = array();

        if (!$containsOwner) {
            $initForeach = false;

            if ($util->RoomManager->countActiveRooms() > 0)
                $initForeach = true;

            if ($initForeach) {
                foreach ($util->RoomManager->getActiveRooms() as $room) {
                    if (String::contains($room->getName(), $searchQuery) && count($rooms) <= 50) {
                        $rooms[] = $room;
                    }
                }
            }
        }

        if (count($rooms) < 50 || $containsOwner || $containsGroup) {
            //TODO :D
        }

        $response->WriteInt32(count($rooms));

        foreach ($rooms as $room) {
            $room->Serialize($response);
        }
    }

    public static function SerializeSearchResultListStatics($staticId, $direct = false, PacketConstructor $response, ClassContainer $util) {
        if (strlen($staticId) == 0)
            $staticId = "official_view";

        if ($staticId != "hotel_view" && $staticId != "roomads_view" && $staticId != "myworld_view" && String::startsWith($staticId, "category__") && $staticId != "official_view") {
            $response->WriteString($staticId); //code
            $response->WriteString(""); //title
            $response->WriteString(1); //0 : no button - 1 : Show More - 2 : Show Back button
            $response->WriteBoolean($staticId != "my" && $staticId != "popular" && $staticId != "official-root"); // collapsed
            $response->WriteInt32($staticId == "official-root" ? 1 : 0); //0 : list - 1 : thumbnail
        }

        $rooms = array();

        switch ($staticId) {
            
        }
    }

}
