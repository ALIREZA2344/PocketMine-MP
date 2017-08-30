<?php

namespace pocketmine\entity;

use pocketmine\network\mcpe\protocol\AddEntityPacket;
use pocketmine\Player;

class Wolf extends Animal implements Tameable, Colorable{
	const NETWORK_ID = 14;

	public $height = 0.969;
	public $width = 0.5;
	public $lenght = 1.594;

	protected $exp_min = 1;
	protected $exp_max = 3;
	protected $maxHealth = 8; //Untamed

	public function initEntity(){
		parent::initEntity();
	}

	public function getName(): string{
		return "Wolf";
	}

	public function spawnTo(Player $player){
		$pk = new AddEntityPacket();
		$pk->entityRuntimeId = $this->getId();
		$pk->type = self::NETWORK_ID;
		$pk->position = $this->asVector3();
		$pk->motion = $this->getMotion();
		$pk->yaw = $this->yaw;
		$pk->pitch = $this->pitch;
		$pk->metadata = $this->dataProperties;
		$player->dataPacket($pk);

		parent::spawnTo($player);
	}

	public function isTamed(){
		return false;
	}

	public function canBeLeashed(){
		return $this->isTamed();//TODO: distance check
	}
}
