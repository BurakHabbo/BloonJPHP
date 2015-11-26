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
    private $status = false;
    private $tokenEnabled = true;
    private $token = array();
    private $whitelistEnabled = true;
    private $whitelist = array();

    public function __construct($tokenEnabled = true, $token = "", $whitelistEnabled = true, $whitelist = "") {
        $this->tokenEnabled = $tokenEnabled;
        $this->token = explode(";", $token);
        $this->whitelistEnabled = $whitelistEnabled;
        $this->whitelist = explode(";", $whitelist);

        $this->server = new WebServer(function(WebRequest $req, WebResponse $res) {
            echo "Hello World!";
            //TODO: Token check, Whitelist check, Router, Controller, Render
        });

        $this->server->isolated = true;
        $this->server->hotReload = true;
    }

    public function start($port = 8080) {
        if (!$this->status) {
            $this->server->port = $port;
            $this->server->run();
            $this->status = true;
        } else {
            Console::WriteLine("WebServerAPI already started !");
        }
    }

    public function getStatus() {
        return $this->status;
    }

}
