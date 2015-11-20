<?php

/*
 * BloonJPHP
 * Habbo R63 Post-Shuffle
 * Based on the work of Burak (burak@burak.fr)
 *
 * https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
 */

use php\lang\ThreadPool;
use php\io\IOException;
use php\lang\Environment;
use php\net\ServerSocket;
use php\lib\String;

require('res://class/Autoloader.php');

$autoloader = new Autoloader;
$autoloader->loadClass();

$config = new Config;
$network = new Network;
$rsa = new RSA;
$headermanager = new HeaderManager;
$furnidataparser = new FurnidataParser;
$webserverapi = new WebServerAPI;

$headermanager->LoadHeader("PRODUCTION-201506161211-776084490");

$config->init("res://habbo.conf");

$rsa->SetPrivate($config->get("crypto.rsaN"), $config->get("crypto.rsaE"), $config->get("crypto.rsaD"));

$pooling = new DatabasePooling($config->get("db.hostname"), $config->get("db.port"), $config->get("db.username"), $config->get("db.password"), $config->get("db.name"), $config->get("db.pool.minsize"), $config->get("db.pool.maxsize"));

$database = new Database();
$database->pool = &$pooling;

$cache = new CacheLoader($database);
$roommanager = new RoomManager($database, $cache);
$roommanager->getRoom(16);
$roommanager->getRoom(17);
$roommanager->getRoom(18);

$events = array();

$autoloader->loadEvents();

Console::WriteLine("Loaded " . count($events) . " events !");

$furnidataparser->setCache();

Console::WriteLine("Loaded " . count($furnidataparser->floorItems) . " floor items and " . count($furnidataparser->wallItems) . " wall items !");

$server = new ServerSocket();
$server->bind($config->get("game.tcp.bindip"), $config->get("game.tcp.port"));
$service = ThreadPool::createFixed($config->get("game.tcp.conlimit"));

$index = new IndexManager();

if ($config->get("api.webserver.enabled"))
    $webserverapi->start($config->get("api.webserver.port"));

Console::WriteLine("Server -> READY! (" . $config->get("game.tcp.bindip") . ":" . $config->get("game.tcp.port") . ")");

$environment = new Environment();
foreach ($autoloader->getClassArray() as $class) {
    $environment->importClass($class);
}

foreach ($autoloader->getEventsArray() as $event) {
    $environment->importClass($event);
}

while (true) {
    $socket = $server->accept();
    $user = new User($socket, $socket->getAddress(), $socket->getPort());
    $index->socket[$user->socketid] = &$user;

    $util = new ClassContainer();
    $util->index = &$index;
    $util->HeaderManager = &$headermanager;
    $util->RSA = &$rsa;
    $util->Database = &$database;
    $util->Cache = &$cache;
    $util->Config = &$config;
    $util->RoomManager = &$roommanager;

    $service->execute(function () use ($user, $events, $util) {
        ob_implicit_flush(true);

        while ($buffer = $user->socketInput->read(4096)) {
            if ($buffer == "<policy-file-request/>" . chr(0)) {
                $user->send(Util::Crossdomain());
                continue;
            }

            $buffer = String::decode($buffer, 'ISO-8859-1');

            if ($user->rc4initialized) {
                $buffer = $user->rc4client->Parse($buffer);
            }

            foreach (BufferManager::Parser($buffer) as $packet) {
                $packet = new PacketParser($packet);

                $header = $packet->getHeader();

                if (isset($events[$header])) {
                    eval($events[$header]["parent"] . '::' . $events[$header]["method"] . '($user, $packet, $util);');
                    Console::WriteLine("- Executed event for " . $header . " (" . $events[$header]["parent"] . '::' . $events[$header]["method"] . ") ");
                } else {
                    Console::WriteLine("- Not found event for " . $header . " : " . $packet->getFullPacket());
                }
            }
        }

        $user->disconnect();
    }, $environment);
}