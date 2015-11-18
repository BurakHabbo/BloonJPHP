<?php
/*
* BloonJPHP
* Habbo R63 Post-Shuffle
* Based on the work of Burak (burak@burak.fr)
*
* https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
*/

class RoomBotEvents {

    public function __construct() {
        $this->initializeEvents();
    }

    private function initializeEvents() {
        EventManager::bind("BotActionsMessageEvent");
        EventManager::bind("BotSpeechListMessageEvent");
        EventManager::bind("PlaceBotMessageEvent");
        EventManager::bind("PlacePetMessageEvent");
        EventManager::bind("MovePetMessageEvent");
        EventManager::bind("PickUpBotMessageEvent");
        EventManager::bind("PickUpItemMessageEvent");
        EventManager::bind("PickUpPetMessageEvent");
        EventManager::bind("HorseAddSaddleMessageEvent");
        EventManager::bind("HorseAllowAllRideMessageEvent");
        EventManager::bind("HorseMountOnMessageEvent");
        EventManager::bind("HorseRemoveSaddleMessageEvent");
        EventManager::bind("GetPetTrainerPanelMessageEvent");
        EventManager::bind("PetGetInformationMessageEvent");
        EventManager::bind("RespectPetMessageEvent");
        EventManager::bind("PetBreedResultMessageEvent");
        EventManager::bind("PetBreedCancelMessageEvent");
        EventManager::bind("CompostMonsterplantMessageEvent");
    }

}

new RoomBotEvents;
