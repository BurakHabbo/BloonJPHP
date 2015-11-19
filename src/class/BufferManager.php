<?php

/*
 * BloonJPHP
 * Habbo R63 Post-Shuffle
 * Based on the work of Burak (burak@burak.fr)
 *
 * https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
 */

Class BufferManager {

    public static function Parser($buffer) {
        $packet = array();
        while (strlen($buffer) > 3) {
            $len = HabboEncoding::DecodeBit32($buffer) + 4;
            $packet[] = substr($buffer, 0, $len);
            $buffer = substr($buffer, $len);
        }
        return $packet;
    }

}
