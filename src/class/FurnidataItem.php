<?php

/*
 * BloonJPHP
 * Habbo R63 Post-Shuffle
 * Based on the work of Burak (burak@burak.fr)
 *
 * https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
 */

class FurnidataItem {

    var $id;
    var $name;
    var $x;
    var $y;
    var $canSit;
    var $canWalk;

    public function __construct($id, $name, $x = 0, $y = 0, $canSit = false, $canWalk = false) {
        $this->id = $id;
        $this->name = $name;
        $this->x = $x;
        $this->y = $y;
        $this->canSit = $canSit;
        $this->canWalk = $canWalk;
    }

}
