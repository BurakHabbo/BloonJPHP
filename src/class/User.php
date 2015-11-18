<?php
/*
* BloonJPHP
* Habbo R63 Post-Shuffle
* Based on the work of Burak (burak@burak.fr)
*
* https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
*/
use php\lib\String;

class User{
	var $socket;
	var $socketid;
	var $socketInput;
	var $socketOutput;
	var $ip;
	var $port;
	var $RELEASE;
	var $HWID;
	var $rc4initialized;
	var $rc4client;
	var $rc4server;
	var $DH;
	var $Prime;
	var $Generator;
	var $habbo;

	public function __construct($socket, $ip, $port){
		$this->socket = $socket;
		$this->socketid = md5($ip.$port);
		$this->socketInput = $this->socket->getInput();
		$this->socketOutput = $this->socket->getOutput();
		$this->ip = $ip;
		$this->port = $port;
		$this->rc4initialized = false;
	}

	public function UpdateCreditsBalance(ClassContainer $util) {
        $response = new PacketConstructor();
        $response->SetHeader($util->HeaderManager->Outgoing("CreditsBalanceMessageComposer"));
        $response->WriteString($this->habbo['credits'] . ".0");
        $this->Send($response->Finalize());
    }

    public function UpdateSeasonalCurrencyBalance($util) {
    	$response = new PacketConstructor();
        $response->SetHeader($util->HeaderManager->Outgoing("ActivityPointsMessageComposer"));
        $response->WriteInt32(3);
        $response->WriteInt32(0);
        $response->WriteInt32($this->habbo['activity_points']);
        $response->WriteInt32(5);
        $response->WriteInt32($this->habbo['vip_points']);
        $response->WriteInt32(105);
        $response->WriteInt32($this->habbo['vip_points']);
        $this->Send($response->Finalize());
    }

	public function send($data) {
		$data = String::encode($data, 'ISO-8859-1');
        if ($this->rc4initialized) {
            $this->socketOutput->write(String::encode($this->rc4server->Parse($data), 'ISO-8859-1'));
        } else {
            $this->socketOutput->write($data);
        }
    }

    public function disconnect(){
    	$this->socket->close();
    }
}