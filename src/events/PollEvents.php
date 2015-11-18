<?php
/*
* BloonJPHP
* Habbo R63 Post-Shuffle
* Based on the work of Burak (burak@burak.fr)
*
* https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
*/

class PollEvents {

    public function __construct() {
        $this->initializeEvents();
    }

    private function initializeEvents() {
        EventManager::bind("AcceptPollMessageEvent");
        EventManager::bind("RefusePollMessageEvent");
        EventManager::bind("AnswerPollQuestionMessageEvent");
    }

}

new PollEvents;
