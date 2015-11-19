<?php

/*
 * BloonJPHP
 * Habbo R63 Post-Shuffle
 * Based on the work of Burak (burak@burak.fr)
 *
 * https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
 */

class IndexManager {

    var $socket;
    var $habboid;

    public function __construct() {
        $this->socket = array();
        $this->habboid = array();
    }

    public function getUserBySocket($socket) {
        return isset($this->socket[$socket]) ? $this->socket[$socket] : false;
    }

    public function getUserbyHabboId($habboid) {
        return isset($this->habboid[$habboid]) ? $this->habboid[$habboid] : false;
    }

}
