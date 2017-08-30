<?php

namespace pocketmine\entity;

use pocketmine\item\Item as ItemItem;
use pocketmine\network\mcpe\protocol\AddEntityPacket;
use pocketmine\Player;

class SnowGolem extends Animal{
	const NETWORK_ID = 21;

	public $height = 1.875;
	public $width = 1.281;
	public $lenght = 0.688;

	protected $exp_min = 0;
	protected $exp_max = 0;
	protected $maxHealth = 4;

	public function initEntity(){
		parent::initEntity();
	}

	public function getName(): string{
		return "Snow Golem";
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

	public function getDrops(): array{
		return [
			ItemItem::get(ItemItem::SNOWBALL, 0, mt_rand(0, 15))
		];
	}

	public function isLeashableType(){
		return false;
	}
}