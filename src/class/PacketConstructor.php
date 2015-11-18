<?php
/*
* BloonJPHP
* Habbo R63 Post-Shuffle
* Based on the work of Burak (burak@burak.fr)
*
* https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
*/

Class PacketConstructor {

    var $packet;

    public function SetHeader($header) {
        $this->packet = HabboEncoding::EncodeBit16($header);
    }

    public function WriteInt16($int) {
        $this->packet .= HabboEncoding::EncodeBit16($int);
    }

    public function WriteInt32($int) {
        $this->packet .= HabboEncoding::EncodeBit32($int);
    }

    public function WriteString($string) {
        $this->packet .= HabboEncoding::EncodeString($string);
    }

    public function WriteBytes($bytes) {
        $this->packet .= $bytes;
    }

    public function WriteByte($bytes) {
        $this->packet .= chr($bytes);
    }

    public function WriteBoolean($bool) {
        $this->packet .= HabboEncoding::EncodeBoolean($bool);
    }

    public function Finalize() {
        $this->packet = HabboEncoding::EncodeBit32(strlen($this->packet)) . $this->packet;
        return $this->packet;
    }

}
