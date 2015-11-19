<?php

/*
 * BloonJPHP
 * Habbo R63 Post-Shuffle
 * Based on the work of Burak (burak@burak.fr)
 *
 * https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
 */

class CatalogEvents {

    public function __construct() {
        $this->initializeEvents();
    }

    private function initializeEvents() {
        EventManager::bind("GetCatalogIndexMessageEvent");
        EventManager::bind("GetCatalogPageMessageEvent");
        EventManager::bind("GetCatalogClubPageMessageEvent");
        EventManager::bind("GetCatalogOfferMessageEvent");
        EventManager::bind("CatalogueOfferConfigMessageEvent");
        EventManager::bind("PurchaseFromCatalogMessageEvent");
        EventManager::bind("PurchaseFromCatalogAsGiftMessageEvent");
        EventManager::bind("GetSellablePetBreedsMessageEvent");
        EventManager::bind("ReloadRecyclerMessageEvent");
        EventManager::bind("GetGiftWrappingConfigurationMessageEvent");
        EventManager::bind("GetRecyclerRewardsMessageEvent");
        EventManager::bind("CatalogPromotionGetRoomsMessageEvent");
        EventManager::bind("GetCatalogClubGiftsMessageEvent");
        EventManager::bind("ChooseClubGiftMessageEvent");
        EventManager::bind("PromoteRoomMessageEvent");
        EventManager::bind("RetrieveSongIDMessageEvent");
        EventManager::bind("CheckPetnameMessageEvent");
        EventManager::bind("EcotronRecycleMessageEvent");
        EventManager::bind("RedeemVoucherMessageEvent");
        EventManager::bind("BuildersClubUpdateFurniCount");
        EventManager::bind("PlaceBuildersFurniture");
        EventManager::bind("PurchaseTargetedOfferMessageEvent");
    }

}

new CatalogEvents;
