<?php

/*
 * BloonJPHP
 * Habbo R63 Post-Shuffle
 * Based on the work of Burak (burak@burak.fr)
 *
 * https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
 */

use php\sql\SqlDriverManager;

class DatabasePooling {

    private $pooling;
    private $pool;

    public function __construct($hostname, $port, $username, $password, $dbname, $minpool, $maxpool) {
        SqlDriverManager::install("mysql");
        $this->pooling = SqlDriverManager::getPool('mysql://' . $hostname . ':' . $port . '/' . $dbname, 'mysql', array('username' => $username, 'password' => $password));
        //$this->pooling->setMaxPoolSize($maxpool);
        $this->pooling->setMaxPoolSize(1);

        $this->pool = $this->pooling->getConnection();
        $this->pool->query('USE bloon;')->update();
    }

    public function getPool() {
        /* $pool = $this->pooling->getConnection();
          $pool->query('USE bloon;')->update();

          return $pool; */
        return $this->pool;
    }

}
