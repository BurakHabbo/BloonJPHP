<?php
/*
* BloonJPHP
* Habbo R63 Post-Shuffle
* Based on the work of Burak (burak@burak.fr)
*
* https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
*/

Class RC4 {

    var $key;
    var $i;
    var $j;
    var $table;

    public function __construct() {
        $this->i = 0;
        $this->j = 0;
        $this->table = Array();
    }

    public function Init($key) {
        $this->key = $key;
        $k = count($this->key);

        while ($this->i < 256) {
            $this->table[$this->i] = $this->i;
            $this->i++;
        }
        $this->i = 0;
        $this->j = 0;
        while ($this->i < 256) {
            $this->j = ((($this->j + $this->table[$this->i]) + $this->key[($this->i % $k)]) % 256);
            $this->Swap($this->i, $this->j);
            $this->i++;
        }
        $this->i = 0;
        $this->j = 0;
    }

    private function Swap($a, $b) {
        $k = $this->table[$a];
        $this->table[$a] = $this->table[$b];
        $this->table[$b] = $k;
    }

    public function Parse($bytes) {
        $result = "";
        for ($a = 0; $a < strlen($bytes); $a++) {
            $this->i = (($this->i + 1) % 256);
            $this->j = (($this->j + $this->table[$this->i]) % 256);
            $this->Swap($this->i, $this->j);
            $tmp1 = ord($bytes[$a]);
            $tmp2 = ($this->table[$this->i] + $this->table[$this->j]) % 256;
            $tmp3 = $this->table[$tmp2];
            $tmp4 = $tmp1 ^ $tmp3;

            $result .= chr($tmp4);
            //$result .= chr(ord($bytes[$a]) ^ $this->table[]);
        }
        return $result;
    }

}
