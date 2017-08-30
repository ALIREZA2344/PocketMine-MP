<?php

namespace pocketmine\entity;

use pocketmine\item\Item as ItemItem;
use pocketmine\network\mcpe\protocol\AddEntityPacket;
use pocketmine\Player;

class Horse extends Animal implements Rideable, Ageable{
	const NETWORK_ID = 23;

	public $width = 0.75;
	public $height = 1.562;

	protected $exp_min = 1;
	protected $exp_max = 3;//TODO
	protected $maxHealth = 10;//TODO

	public function initEntity(){
		$this->setDataFlag(self::DATA_FLAGS, self::DATA_FLAG_TAMED);
		$this->setDataFlag(self::DATA_FLAGS, self::DATA_FLAG_SADDLED);
		$this->setDataFlag(self::DATA_FLAGS, self::DATA_FLAG_INLOVE);
		parent::initEntity();
	}

	public function getName(): string{
		return "Horse";//TODO: Name by type
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
		$drops = [
			ItemItem::get(ItemItem::LEATHER, 0, mt_rand(0, 2))
		];

		return $drops;
	}

	public function canBeLeashed(){
		return true; //TODO: distance check, already leashed check
	}
}
