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
        $this->server = new WebServer(function(WebRequest $req, WebResponse $res) {
            require 'res://class/WebServerRouter.php';
            require 'res://class/WebServerRoute.php';

            $current = WebServer::current();
            $drop = false;

            if ($current->tokenEnabled) {
                $drop = true;

                foreach ($req->cookies as $cookie) {
                    if (strtolower($cookie['name']) == "token" && in_array($cookie['value'], $current->token)) {
                        $drop = false;
                    }
                }
            }

            if ($current->whitelistEnabled && !in_array($req->ip, $current->whitelist))
                $drop = true;

            if (!$drop) {

                $router = new WebServerRouter($req->servletPath, $req->method);

                $router->get('/', function() {
                    echo "Root";
                });

                $router->run();

                /* Some debug data */
                /* var_dump($req->method);
                  var_dump($req->scheme);
                  var_dump($req->pathInfo);
                  var_dump($req->servletPath);
                  var_dump($req->queryString);
                  var_dump($req->authType);
                  var_dump($req->url);
                  var_dump($req->port);
                  var_dump($req->ip);
                  var_dump($req->cookies); */
            } else {
                $res->status = 403;
                echo "Access denied";
            }
        });

        $this->server->tokenEnabled = $this->tokenEnabled = $tokenEnabled;
        $this->server->token = $this->token = explode(";", $token);
        $this->server->whitelistEnabled = $this->whitelistEnabled = $whitelistEnabled;
        $this->server->whitelist = $this->whitelist = explode(";", $whitelist);
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
