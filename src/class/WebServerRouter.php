<?php

/*
 * BloonJPHP
 * Habbo R63 Post-Shuffle
 * Based on the work of Burak (burak@burak.fr)
 *
 * https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
 */

class WebServerRouter {

    private $url;
    private $method;
    private $routes = array();

    public function __construct($url, $method) {
        $this->url = $url;
        $this->method = $method;
        $this->routes['GET'] = array();
        $this->routes['POST'] = array();
        $this->routes['PUT'] = array();
        $this->routes['DELETE'] = array();
    }

    public function get($path, $callback) {
        $this->add($path, $callback, 'GET');
    }

    public function post($path, $callback) {
        $this->add($path, $callback, 'POST');
    }

    public function put($path, $callback) {
        $this->add($path, $callback, 'PUT');
    }

    public function delete($path, $callback) {
        $this->add($path, $callback, 'DELETE');
    }

    private function add($path, $callback, $method) {
        $this->routes[$method][] = new WebServerRoute($path, $callback);
    }

    public function run() {
        if (!isset($this->routes[$this->method]))
            print("Method not found.");

        foreach ($this->routes[$this->method] as $route) {
            if ($route->match($this->url)) {
                return $route->call();
            }
        }

        print("Not found.");
    }

}
