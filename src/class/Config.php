<?php
/*
* BloonJPHP
* Habbo R63 Post-Shuffle
* Based on the work of Burak (burak@burak.fr)
*
* https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
*/
use php\lib\String;
use php\util\Regex;

Class Config {

    private $config;

    public function init($filename) {
        //if (file_exists($filename)) { //jphp issue ? never return true when file exist
            $file = file_get_contents($filename);
            $file = String::replace($file, "\r", "");
            $file = explode("\n", $file);

            $this->config = array();

            foreach($file as $line){
                $exp = explode("=", $line);
                if(isset($exp[1])){
                    $key = $exp[0];
                    $value = String::replace($line, $exp[0]."=", "");
                    if($value == "1") $value = true;
                    if($value == "0") $value = false;

                    $this->config[$key] = $value;
                }
            }
        //} else {
        //    Console::WriteLine("Config file " . $filename . " is missing !");
        //    exit;
        //}
    }

    public function get($key) {
        return isset($this->config[$key]) ? $this->config[$key] : "";
    }

}
