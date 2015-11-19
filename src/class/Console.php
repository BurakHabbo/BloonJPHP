<?php

/*
 * BloonJPHP
 * Habbo R63 Post-Shuffle
 * Based on the work of Burak (burak@burak.fr)
 *
 * https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
 */

Class Console {

    public static function Write($str = "") {
        print($str);
    }

    public static function WriteLine($str = "") {
        print(Util::ParseString($str) . "\r\n");
    }

    public static function Beep() {
        print(chr(7));
    }

}
