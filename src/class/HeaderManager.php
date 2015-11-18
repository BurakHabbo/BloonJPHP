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

Class HeaderManager {

    var $Incoming;
    var $Outgoing;

    public function LoadHeader($RELEASE, $IncomingFile = "Incoming.conf", $OutgoingFile = "Outgoing.conf") {
        $incoming = "res://".$RELEASE . "/" . $IncomingFile;

        $file = file_get_contents($incoming);
        $file = String::replace($file, "\r", "");
        $file = explode("\n", $file);
        $this->Incoming = array();
        foreach ($file as $line) {
            $exp = explode("=", $line);
            
            if(isset($exp[1])){
                $this->Incoming[trim($exp[0])] = (int) $exp[1];
            }
        }

        $outgoing = "res://".$RELEASE . "/" . $OutgoingFile;

        $file = file_get_contents($outgoing);
        $file = String::replace($file, "\r", "");
        $file = explode("\n", $file);
        $this->Outgoing = array();
        foreach ($file as $line) {
            $exp = explode("=", $line);

            if(isset($exp[1])){
                $this->Outgoing[trim($exp[0])] = (int) $exp[1];
            }
        }
    }

    public function Incoming($name) {
        return isset($this->Incoming[$name]) ? $this->Incoming[$name] : $this->Error($name, 1);
    }

    public function Outgoing($name) {
        return isset($this->Outgoing[$name]) ? $this->Outgoing[$name] : $this->Error($name, 0);
    }

    private function Error($name, $direction){
        Console::WriteLine($name . " ".($direction == 1 ? "incoming" : "outgoing")." not found !");

        return 0;
    }

}
