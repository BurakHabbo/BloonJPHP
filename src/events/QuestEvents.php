<?php

/*
 * BloonJPHP
 * Habbo R63 Post-Shuffle
 * Based on the work of Burak (burak@burak.fr)
 *
 * https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
 */

class QuestEvents {

    public function __construct() {
        $this->initializeEvents();
    }

    private function initializeEvents() {
        EventManager::bind("OpenQuestsMessageEvent");
        EventManager::bind("LoadNextQuestMessageEvent");
        EventManager::bind("QuestCancelMessageEvent");
        EventManager::bind("QuestSeasonalStartMessageEvent");
        EventManager::bind("QuestStartMessageEvent");
        EventManager::bind("OpenAchievementsBoxMessageEvent");
        EventManager::bind("CompleteSafetyQuizMessageEvent");
    }

}

new QuestEvents;
