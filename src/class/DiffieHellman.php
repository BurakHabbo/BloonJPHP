<?php

/*
 * BloonJPHP
 * Habbo R63 Post-Shuffle
 * Based on the work of Burak (burak@burak.fr)
 *
 * https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
 */

Class DiffieHellman {

    var $Prime;
    var $Generator;
    var $PrivateKey;
    var $PublicKey;
    var $PublicClientKey;
    var $SharedKey;

    public function GenerateDH($prime = "", $generator = "", $base = 10) {
        if ($prime != "") {
            $this->Prime = new BigInteger($prime, $base);
        } else {
            $this->Prime = new BigInteger("114670925920269957593299136150366957983142588366300079186349531"); //TODO: generate random prime
        }

        if ($generator != "") {
            $this->Generator = new BigInteger($generator, $base);
        } else {
            $this->Generator = new BigInteger("1589935137502239924254699078669119674538324391752663931735947"); //TODO: generate random generator
        }

        $this->PrivateKey = new BigInteger(Util::GenerateRandomHexString(30), 16);

        if ($this->Generator->compare($this->Prime) == 1) {
            $temp = $this->Prime;
            $this->Prime = $this->Generator;
            $this->Generator = $temp;
        }

        $this->PublicKey = $this->Generator->modPow($this->PrivateKey, $this->Prime);
    }

    public function GenerateSharedKey($clientkey, $base = 10) {
        $this->PublicClientKey = new BigInteger($clientkey, $base);
        $this->SharedKey = $this->PublicClientKey->modPow($this->PrivateKey, $this->Prime);
    }

    public function GetPublicKey($bytearray = false) {
        if ($bytearray)
            return Util::toByteArray($this->PublicKey);
        return $this->PublicKey->toString();
    }

    public function GetSharedKey($bytearray = false) {
        if ($bytearray)
            return Util::toByteArray($this->SharedKey);
        return $this->SharedKey->toString();
    }

    public function GetPrime($bytearray = false) {
        if ($bytearray)
            return Util::toByteArray($this->Prime);
        return $this->Prime->toString();
    }

    public function GetGenerator($bytearray = false) {
        if ($bytearray)
            return Util::toByteArray($this->Generator);
        return $this->Generator->toString();
    }

}
