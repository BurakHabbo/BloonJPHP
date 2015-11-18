<?php
/*
* BloonJPHP
* Habbo R63 Post-Shuffle
* Based on the work of Burak (burak@burak.fr)
*
* https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
*/
use php\lib\String;

Class Util {

    public static function GenerateRandomHexString($len) {
        $output = sha1(sha1(rand()) . md5(rand() . sha1(rand()))) . sha1(sha1(rand()) . md5(rand() . sha1(rand())));
        return substr($output, 0, $len);
    }

    public static function toByteArray($gmp) {
        $result = Array();
        $base16 = $gmp->toString(16);
        if (strlen($base16) % 2 != 0) {
            $base16 = "0" . $base16;
        }
        $hexs = str_split($base16, 2);
        foreach ($hexs as $hex) {
            $result[] = hexdec($hex);
        }
        return $result;
    }

    public static function ParseString($string) {
        for ($i = 0; $i < 20; $i++) {
            $string = String::replace($string, chr($i), "[" . $i . "]");
        }
        for ($i = 65000; $i < 65535; $i++) {
            $string = String::replace($string, chr($i), "[" . $i . "]");
        }
        return $string;
    }

    public static function Crossdomain() {
        return '<?xml version="1.0"?>
		<!DOCTYPE cross-domain-policy SYSTEM "/xml/dtds/cross-domain-policy.dtd">
		<cross-domain-policy>
		<allow-access-from domain="*" to-ports="1-31111" />
		</cross-domain-policy>' . chr(0);
    }

    public static function EventMethod($classname, $method) {
        return array("parent" => $classname, "method" => $method);
    }

    public static function RotationCalculate($one, $two) {
        $one_x = $one[0];
        $one_y = $one[1];
        $two_x = $two[0];
        $two_y = $two[1];

        if ($one_x > $two_x && $one_y > $two_y) {
            return 7;
        } else if ($one_x < $two_x && $one_y < $two_y) {
            return 3;
        } else if ($one_x > $two_x && $one_y < $two_y) {
            return 5;
        } else if ($one_x < $two_x && $one_y > $two_y) {
            return 1;
        } else if ($one_x > $two_x) {
            return 6;
        } else if ($one_x < $two_x) {
            return 2;
        } else if ($one_y < $two_y) {
            return 4;
        } else if ($one_y > $two_y) {
            return 0;
        }
        return 0;
    }

    public static function startsWith($haystack, $needle) {
        // search backwards starting from haystack length characters from the end
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
    }

    public static function endsWith($haystack, $needle) {
        // search forward starting from end minus needle length characters
        return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
    }

    public static function ListPackage(){
        foreach (get_loaded_extensions() as $ext) {
            $reflection = new ReflectionExtension($ext);
            foreach ($reflection->getClassNames() as $class) {
                echo $reflection->getName() . ': ' . $class . "\n";
            }
        }
    }

}
