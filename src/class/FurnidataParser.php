<?php

/*
 * BloonJPHP
 * Habbo R63 Post-Shuffle
 * Based on the work of Burak (burak@burak.fr)
 *
 * https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
 */

use php\xml\XmlProcessor;
use php\io\Stream;

class FurnidataParser {

    public $floorItems = array();
    public $wallItems = array();
    private $xmlParser;
    private $xmlDocument;

    public function setCache() {
        $this->xmlParser = new XmlProcessor();
        $this->xmlDocument = $this->xmlParser->parse(Stream::getContents("http://localhost/game/gamedata/furnidata.xml"));

        $iterator = $this->xmlDocument->findAll("/furnidata/roomitemtypes/furnitype");

        while ($current = $iterator->current()) {
            $node = $current->toModel();
            $this->floorItems[$node['@classname']] = new FurnidataItem((int) $node['@id'], $node['name'], (int) $node['xdim'], (int) $node['ydim'], $node['cansiton'] == "1", $node['canstandon'] == "1");
            $iterator->next();
        }

        $iterator = $this->xmlDocument->findAll("/furnidata/wallitemtypes/furnitype");

        while ($current = $iterator->current()) {
            $node = $current->toModel();
            $this->wallItems[$node['@classname']] = new FurnidataItem((int) $node['@id'], $node['name']);
            $iterator->next();
        }
    }

}
