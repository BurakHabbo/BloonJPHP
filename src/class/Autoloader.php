<?php
/*
* BloonJPHP
* Habbo R63 Post-Shuffle
* Based on the work of Burak (burak@burak.fr)
*
* https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
*/

Class Autoloader{
	public static $class = array("CacheLoader", "Database", "DatabasePooling", "RC4", "PacketConstructor", "DiffieHellman", "EventManager", "BigInteger", "Network", "Util", "Config", "RSA", "HeaderManager", "Console", "ClassContainer", "IndexManager", "User", "BufferManager", "HabboEncoding", "PacketParser");

	public static $events = array("CatalogEvents", "FriendEvents", "GameEvents", "GroupEvents", "HabboEvents", "HandshakeEvents", "HelpEvents", "InventoryEvents", "LandingEvents", "ModerationToolEvents", "NavigatorEvents", "OtherEvents", "PollEvents", "QuestEvents", "RoomBotEvents", "RoomEvents", "RoomItemEvents", "RoomWiredEvents", "UserRoomEvents");

	public static function loadClass(){
		foreach (self::$class as $class) {
			require('res://class/'.$class.'.php');
		}
	}

	public static function loadEvents(){
		foreach (self::$events as $events) {
			require('res://events/'.$events.'.php');
		}
	}
}