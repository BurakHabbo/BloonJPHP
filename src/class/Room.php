<?php

/*
 * BloonJPHP
 * Habbo R63 Post-Shuffle
 * Based on the work of Burak (burak@burak.fr)
 *
 * https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
 */

class Room {

    private $database;
    private $id;
    private $owner = array();
    private $roomtype;
    private $name;
    private $description;
    private $category;
    private $state;
    private $usersNow = 0;
    private $usersMax = 50;
    private $modelName;
    private $model = array();
    private $score;
    private $allowPets;
    private $wallpaper;
    private $floor;
    private $landscape;
    private $tags = array();
    private $rights = array();
    private $muted = false;
    private $group;
    private $event;

    public function __construct($id, Database $database) {
        $this->database = $database;
        $data = $this->database->Query("SELECT * FROM rooms WHERE id = ? LIMIT 1", array($id));

        if (count($data) != 1)
            return 0;

        $data = $data[0];

        $this->id = $id;
        $this->roomtype = $data['roomtype'];
        $this->name = $data['caption'];
        $this->description = $data['description'];
        $this->category = (int) $data['category'];

        $this->state = 0;

        if ($data['state'] == "closed") {
            $this->state = 1;
        } else if ($data['state'] == "password") {
            $this->state = 2;
        }

        $this->usersMax = (int) $data['users_max'];
        $this->modelName = $data['model_name']; //need security check here
        $this->score = (int) $data['score'];
        $this->allowPets = $data['allow_pets'] == 1;
        $this->tags = explode(',', $data['tags']);

        $owner = $this->database->Query("SELECT id,username,look FROM users WHERE username = ?", array($data['owner']));

        if (count($owner) != 1)
            return 0;

        $owner = $owner[0];

        $this->owner['id'] = (int) $owner['id'];
        $this->owner['username'] = $owner['username'];
        $this->owner['look'] = $owner['look'];

        $this->rights = $this->database->Query("SELECT u.id,u.username FROM room_rights r, users u WHERE r.user_id = u.id AND r.room_id = ?", array($id));

        foreach ($util->Cache->roommodels as $model) {
            if ($model['id'] == $this->modelName) {
                $this->model = $model;
                break;
            }
        }
    }

    public function getName() {
        return $this->name;
    }

    public function getUsersNow() {
        return $this->usersNow;
    }

    public function getId() {
        return $this->id;
    }

    public function getModelName() {
        return $this->modelName;
    }

    public function getWallpaper() {
        return $this->wallpaper;
    }

    public function getFloor() {
        return $this->floor;
    }

    public function getLandscape() {
        return $this->landscape;
    }

    public function getScore() {
        return $this->score;
    }

    public function getUsersMax() {
        return $this->usersMax;
    }

    public function Serialize(PacketConstructor $response, $showEvents = false, $enterRoom = false) {
        $response->WriteInt32($this->id);
        $response->WriteString($this->name);
        $response->WriteInt32($this->owner['id']);
        $response->WriteString($this->owner['username']);
        $response->WriteInt32($this->state);
        $response->WriteInt32($this->usersNow);
        $response->WriteInt32($this->usersMax);
        $response->WriteString($this->description);
        $response->WriteInt32(0); //tradeState
        $response->WriteInt32($this->score);
        $response->WriteInt32(0); //ranking
        $response->WriteInt32($this->category);

        $response->WriteInt32(count($this->tags));
        foreach ($this->tags as $tag) {
            $response->WriteString($tag);
        }

        $imageData = "";

        $enumType = $enterRoom ? 32 : 0;

        if ($this->group)
            $enumType += 2;

        if ($showEvents && $this->event)
            $enumType += 4;

        if ($this->roomtype == "private")
            $enumType += 8;

        if ($this->allowPets)
            $enumType += 16;

        $response->WriteInt32($enumType);

        if ($imageData != "")
            $response->WriteString($imageData);

        if ($this->group) {
            $response->WriteInt32($this->group->getId());
            $response->WriteString($this->group->getName());
            $response->WriteString($this->group->getBadge());
        }

        if ($this->event) {
            $response->WriteString($this->event->getName());
            $response->WriteString($this->event->getDescription());
            $response->WriteInt32(10); //floor($this->event->getExpireTime() - time() / 60);
        }
    }

    public function SerializeRoomInformation($show = false, ClassContainer $util, User $user) {
        $this->SerializeRoomData($util, $user, false, false, $show); //$this->id != $user->currentRoomId

        $response = new PacketConstructor;
        $response->SetHeader($util->HeaderManager->Outgoing("LoadRoomRightsListMessageComposer"));
        $response->WriteInt32($this->id);
        $response->WriteInt32(count($this->rights));

        foreach ($this->rights as $right) {
            $response->WriteInt32($right['id']);
            $response->WriteString($right['username']);
        }
        $user->Send($response->Finalize());
    }

    public function SerializeRoomData(ClassContainer $util, User $user, $isNotReload = false, $sendRoom = false, $show = true) {
        $response = new PacketConstructor;
        $response->SetHeader($util->HeaderManager->Outgoing("RoomDataMessageComposer"));
        $response->WriteBoolean($show);
        $this->Serialize($response, true, !$isNotReload);
        $response->WriteBoolean($isNotReload);
        $response->WriteBoolean(false); //public ?
        $response->WriteBoolean(!$isNotReload);
        $response->WriteBoolean($this->muted);
        $response->WriteInt32(0); //whocanmute
        $response->WriteInt32(0); //whocankick
        $response->WriteInt32(0); //whocanban
        $response->WriteBoolean(true); //room rights, need check here
        $response->WriteInt32(0); //chat type
        $response->WriteInt32(0); //chat balloon
        $response->WriteInt32(0); //chat speed
        $response->WriteInt32(14); //chat maxdistance
        $response->WriteInt32(0); //chat flood protection

        /* if ($sendRoom == null)
          return; */

        //if ($sendRoom) {
        //$this->Send($response->Finalize());
        //} else {
        //Console::WriteLine($response->Finalize());
        $user->Send($response->Finalize());
        //}
    }

}
