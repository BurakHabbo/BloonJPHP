<?php

/*
 * BloonJPHP
 * Habbo R63 Post-Shuffle
 * Based on the work of Burak (burak@burak.fr)
 *
 * https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
 */

use php\lib\String;

Class RSA {

    var $n;
    var $e;
    var $d;
    var $p;
    var $q;
    var $dmp1;
    var $dmq1;
    var $coeff;
    var $canDecrypt;
    var $canEncrypt;
    var $FullByte;
    var $RandomByte;

    public function __construct() {
        $this->n = 0;
        $this->e = 0;
        $this->d = 0;
        $this->p = 0;
        $this->q = 0;
        $this->dmp1 = 0;
        $this->dmq1 = 0;
        $this->coeff = 0;
        $this->canDecrypt = false;
        $this->canEncrypt = false;
        $this->FullByte = 1;
        $this->RandomByte = 2;
    }

    public function SetPublic($n, $e) {
        $n = String::replace($n, "\r", "");
        $n = String::replace($n, "\n", "");
        $e = String::replace($e, "\r", "");
        $e = String::replace($e, "\n", "");

        $this->n = gmp_init($n, 16);
        $this->e = gmp_init($n, 16);

        $this->canEncrypt = true;
    }

    public function SetPrivate($n, $e, $d) {
        $n = String::replace($n, "\r", "");
        $n = String::replace($n, "\n", "");
        $e = String::replace($e, "\r", "");
        $e = String::replace($e, "\n", "");
        $d = String::replace($d, "\r", "");
        $d = String::replace($d, "\n", "");

        $this->n = new BigInteger($n, 16);
        $this->e = new BigInteger($e, 16);
        $this->d = new BigInteger($d, 16);
        $this->canEncrypt = true;
        $this->canDecrypt = true;
    }

    private function encode($string) {
        $ascii = array();
        $string_array = str_split($string);

        for ($i = 0; $i < count($string_array); $i++) {
            $char = ord($string_array[$i]);
            $ascii[$i] = $char;
        }

        return $ascii;
    }

    public static function toHexInteger($array) {
        $result = "";
        foreach ($array as $int) {
            $tmp = dechex($int);
            if (strlen($tmp) == 1)
                $tmp = "0" . $tmp;
            $result .= $tmp;
        }
        return new BigInteger($result, 16);
    }

    private function GetBlockSize() {
        return floor((strlen($this->n->toString(16))) / 2);
    }

    private function DoPrivate($x) {
        if ($this->canDecrypt) {
            return $x->modPow($this->d, $this->n);
        }
        return 0;
    }

    private function DoPublic($x) {
        if ($this->canEncrypt) {
            return gmp_powm($x, $this->e, $this->n);
        }
        return 0;
    }

    private function pkcs1pad($d, $n, $type) {
        $data = $this->encode($d);
        $out = array();
        for ($x = 0; $x < $n; $x++) {
            $out[$x] = 0;
        }

        $p = 0;
        $i = count($data) - 1;
        while ($i >= $p && $n > 11) {
            $out[--$n] = $data[$i--];
        }
        $out[--$n] = 0;

        while ($n > 2) {
            $out[--$n] = 0xFF;
        }

        $out[--$n] = 1; //type 1 = 0xFF, 2 = random
        $out[--$n] = 0;
        return $this->toHexInteger($out);
    }

    private function pkcs1unpad($d, $n, $type) {
        $b = Util::toByteArray($d);
        $i = 0;

        while ($i < count($b) && $b[$i] == 0)
            ++$i;
        if (count($b) - $i != $n - 1 || $b[$i] != 2)
            return null;
        ++$i;
        while ($b[$i] != 0) {
            if (++$i >= count($b))
                return null;
        }
        $result = "";
        while (++$i < count($b)) {
            $c = $b[$i] & 255;
            if ($c < 128) {
                $result.= chr($c);
            } else if (($c > 191) && ($c < 224)) {
                $result.= chr((($c & 31) << 6) | ($b[$i + 1] & 63));
                ++$i;
            } else {
                $result.= chr((($c & 15) << 12) | (($b[$i + 1] & 63) << 6) | ($b[$i + 2] & 63));
                $i += 2;
            }
        }
        return $result;
    }

    public function Verify($bytes) {
        $c = new BigInteger($bytes, 16);
        $m = $this->DoPrivate($c);
        return $this->pkcs1unpad($m, $this->GetBlockSize(), $this->FullByte);
    }

    public function Sign($bytes) {
        $m = $this->pkcs1pad($bytes, $this->GetBlockSize(), $this->FullByte);
        $c = $this->DoPrivate($m);
        return $c->toString(16);
    }

    public function Decrypt($bytes) {
        $c = gmp_init($bytes, 16);
        $m = $this->DoPublic($c);
        return $this->pkcs1unpad($m, $this->GetBlockSize(), $this->FullByte);
    }

    public function Encrypt($bytes) {
        $m = $this->pkcs1pad($bytes, $this->GetBlockSize(), $this->FullByte);
        $c = $this->DoPublic($m);
        return gmp_strval($c, 16);
    }

}
