<?php

/*
 * BloonJPHP
 * Habbo R63 Post-Shuffle
 * Based on the work of Burak (burak@burak.fr)
 *
 * https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
 */

use php\util\Flow;
use php\sql\SqlResult;

class Database {

    var $pool;

    public function __construct() {
        
    }

    public function Query($query, $params = array()) {
        $pool = $this->pool->getPool();

        try {
            $result = Flow::of($pool->query($query, $params))
                    ->map(function (SqlResult $result) {
                        if (count($result) > 0) {
                            return $result->toArray();
                        } else {
                            return array();
                        }
                    })
                    ->toArray();
        } catch (Exception $e) {
            $result = array();
        }

        return $result;
    }

    public function Exec($query, $params = array()) {
        $pool = $this->pool->getPool();

        $pool->query($query, $params)->update();
    }

}
