<?php

/*
 * BloonJPHP
 * Habbo R63 Post-Shuffle
 * Based on the work of Burak (burak@burak.fr)
 *
 * https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
 */

use php\webserver\WebServer;
use php\webserver\WebResponse;
use php\webserver\WebRequest;

class WebServerAPI {

    private $server;

    public function __construct() {
        $this->server = new WebServer(function(WebRequest $req, WebResponse $res) {
            echo "Hello World!";
        });

        $this->server->isolated = true;
        $this->server->hotReload = true;
    }

    public function start($port = 8080) {
        $this->server->port = $port;
        $this->server->run();
    }

}
