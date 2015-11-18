<?php
/*
* BloonJPHP
* Habbo R63 Post-Shuffle
* Based on the work of Burak (burak@burak.fr)
*
* https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
*/
use php\io\Stream;
use php\lib\String;

Class HandshakeEvents {

    public function __construct() {
        $this->initializeEvents();
    }

    private function initializeEvents() {
        EventManager::bind("ClientVersionMessageEvent");
        EventManager::bind("InitCryptoMessageEvent");
        EventManager::bind("GenerateSecretKeyMessageEvent");
        EventManager::bind("ClientVarsEvent");
        EventManager::bind("UniqueIDMessageEvent");
        EventManager::bind("SSOTicketMessageEvent");
    }

    public static function ClientVersionMessageEvent(User $user, PacketParser $packet, ClassContainer $util) {
        $user->RELEASE = $packet->readString();
    }

    public static function InitCryptoMessageEvent(User $user, PacketParser $packet, ClassContainer $util) {
        if($util->Config->Get("crypto.enabled")){
            $user->DH = new DiffieHellman;

            if($util->Config->Get("crypto.DHstatic")){
                $user->DH->GenerateDH($util->Config->Get("crypto.DHstaticPrime"), $util->Config->Get("crypto.DHstaticGenerator"));
            }else{
                $user->DH->GenerateDH();
            }

            $response = new PacketConstructor;
            $response->SetHeader($util->HeaderManager->Outgoing("InitCryptoMessageComposer"));
            $response->WriteString($util->RSA->Sign($user->DH->GetPrime()));
            $response->WriteString($util->RSA->Sign($user->DH->GetGenerator()));
            $user->Send($response->Finalize());
        }else{
            $response = new PacketConstructor;
            $response->SetHeader($util->HeaderManager->Outgoing("InitCryptoMessageComposer"));
            $response->WriteString("Bloon");
            $response->WriteString("Crypto disabled");
            $user->Send($response->Finalize());
        }
    }

    public static function GenerateSecretKeyMessageEvent(User $user, PacketParser $packet, ClassContainer $util) {
        if($util->Config->Get("crypto.enabled")){
            $rsadata = $packet->readString();
            $user->DH->GenerateSharedKey(String::Replace($util->RSA->Verify($rsadata), chr(0), ""));

            $response = new PacketConstructor;
            $response->SetHeader($util->HeaderManager->Outgoing("SecretKeyMessageComposer"));
            $response->WriteString($util->RSA->Sign($user->DH->GetPublicKey()));
            $response->WriteBoolean(true);
            $user->Send($response->Finalize());

            $user->rc4client = new RC4();
            $user->rc4server = new RC4();
            $user->rc4client->Init($user->DH->GetSharedKey(true));
            $user->rc4server->Init($user->DH->GetSharedKey(true));
            $user->rc4initialized = true;
        }else{
            $response = new PacketConstructor;
            $response->SetHeader($util->HeaderManager->Outgoing("SecretKeyMessageComposer"));
            $response->WriteString("Crypto disabled");
            $response->WriteBoolean(false);
            $user->Send($response->Finalize());
        }
    }

    public static function ClientVarsEvent(User $user, PacketParser $packet, ClassContainer $util) {
        $user->FLASHID = $packet->readInt32();
        $user->FLASHBASE = $packet->readString();
        $user->FLASHVARS = $packet->readString();
    }

    public static function UniqueIDMessageEvent(User $user, PacketParser $packet, ClassContainer $util) {
        $packet->readString();
        $user->HWID = $packet->readString();
        //TODO: Check HWID ban
    }

    public static function SSOTicketMessageEvent(User $user, PacketParser $packet, ClassContainer $util) {
        $ticket = $packet->readString();

        $query = $util->Database->Query("SELECT * FROM users WHERE auth_ticket = ? LIMIT 1", array($ticket));

        if (count($query) == 0) {
            Console::WriteLine("User not found, ticket : " . $ticket);
            $user->disconnect();
        } else {
            $check = $util->index->GetUserbyHabboId($query[0]['id']);

            if ($check) {
                $check->disconnect();
            }

            $user->habbo = $query[0];

            $util->index->habboid[$user->habbo['id']] = &$user;

            Console::WriteLine("- " . $user->habbo['username'] . " logged in !");
            $util->Database->Exec("UPDATE users SET online = '1' WHERE id = ?", array($user->habbo['id']));
            $util->Database->Exec("UPDATE server_status SET users_online = users_online + 1");

            $response = new PacketConstructor;
            $response->SetHeader($util->HeaderManager->Outgoing("UniqueMachineIDMessageComposer"));
            $response->WriteString($user->HWID);
            $user->Send($response->Finalize());

            $response = new PacketConstructor;
            $response->SetHeader($util->HeaderManager->Outgoing("AuthenticationOKMessageComposer"));
            $user->Send($response->Finalize());

            $response = new PacketConstructor;
            $response->SetHeader($util->HeaderManager->Outgoing("HomeRoomMessageComposer"));
            $response->WriteInt32($user->habbo['home_room']);
            $response->WriteInt32($user->habbo['home_room']);
            $user->Send($response->Finalize());
            
            $response = new PacketConstructor;
            $response->SetHeader($util->HeaderManager->Outgoing("MinimailCountMessageComposer"));
            $response->WriteInt32(0);
            $user->Send($response->Finalize());

            $favoriterooms = $util->Database->Query("SELECT room_id FROM user_favorites WHERE user_id = ?", array($user->habbo['id']));
            $response = new PacketConstructor;
            $response->SetHeader($util->HeaderManager->Outgoing("FavouriteRoomsMessageComposer"));
            $response->WriteInt32(30);
            $response->WriteInt32(count($favoriterooms));
            foreach ($favoriterooms as $favorite) {
                $response->WriteInt32($favorite['room_id']);
            }
            $user->Send($response->Finalize());

            $response = new PacketConstructor;
            $response->SetHeader($util->HeaderManager->Outgoing("EnableNotificationsMessageComposer"));
            $response->WriteBoolean(true);
            $response->WriteBoolean(false);
            $user->Send($response->Finalize());

            $response = new PacketConstructor;
            $response->SetHeader($util->HeaderManager->Outgoing("EnableTradingMessageComposer"));
            $response->WriteBoolean(true);
            $user->Send($response->Finalize());
        }
    }

}

new HandshakeEvents;
