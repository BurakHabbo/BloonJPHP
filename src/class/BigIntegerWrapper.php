<?php

/*
 * BloonJPHP
 * Habbo R63 Post-Shuffle
 * Based on the work of Burak (burak@burak.fr)
 *
 * https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
 */

use php\lang\JavaClass;

/* Unfinished, don't work. Alternative found. */

Class BigInteger {

    public $instance;

    public function __construct($value, $base) {
        $this->instance = new JavaClass("java.math.BigInteger")->newInstanceArgs(array("string", "int"), array($value, $base));
    }

    public function toString() {
        return $this->instance->getClass()->getDeclaredMethod("toString", array())->invoke($this->instance);
    }

    public function nextProbablePrime() {
        return $this->instance->getClass()->getDeclaredMethod("nextProbablePrime", array())->invoke($this->instance);
    }

    public static function compareTo($from, $val) {
        return $from->getClass()->getDeclaredMethod("compareTo", array($val->getClass()))->invoke($from->instance);
    }

}

?>