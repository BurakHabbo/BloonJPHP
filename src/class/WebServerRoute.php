<?php

/*
 * BloonJPHP
 * Habbo R63 Post-Shuffle
 * Based on the work of Burak (burak@burak.fr)
 *
 * https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
 */

class WebServerRoute {

    private $path;
    private $callback;

    public function __construct($path, $callback) {
        $this->path = $path;
        $this->callback = $callback;
    }

    public function match($url) {
        return true;
    }

    public function call() {
        call_user_func_array($this->callback, array());
    }

}
