<?php

/*
 * BloonJPHP
 * Habbo R63 Post-Shuffle
 * Based on the work of Burak (burak@burak.fr)
 *
 * https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
 */

use php\util\Regex;

class WebServerRoute {

    private $path;
    private $callback;

    public function __construct($path, $callback) {
        $this->path = $path;
        $this->callback = $callback;
    }

    public function match($url) {
        /* Unfinished shit */

        $url = trim($url, '/');
        $regex = Regex::of('#:([\w]+)#');

        $path = $regex->with($this->path)->replaceWithCallback(function(Regex $self) {
            return '([^/]+)';
        });

        $reg = Regex::of("#^" . $path . "$#i");

        foreach ($reg->with($url) as $match) {
            var_dump($match);
        }

        return false;
    }

    public function call() {
        call_user_func_array($this->callback, array());
    }

}
