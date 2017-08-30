<?php

namespace pocketmine\entity;

use pocketmine\item\Item as ItemItem;
use pocketmine\network\mcpe\protocol\AddEntityPacket;
use pocketmine\Player;

class Donkey extends Animal implements Rideable{
	const NETWORK_ID = 24;

	public $width = 0.75;
	public $height = 1.562;
	public $lenght = 1.5;//TODO

	protected $exp_min = 1;
	protected $exp_max = 3;//TODO
	protected $maxHealth = 10;//TODO

	public function initEntity(){
		parent::initEntity();
	}

	public function getName(): string{
		return "Donkey";
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

	public function isBaby(): bool{
		return $this->getDataFlag(self::DATA_FLAGS, self::DATA_FLAG_BABY);
	}

	public function getDrops(): array{
		$drops = [
			ItemItem::get(ItemItem::LEATHER, 0, mt_rand(0, 2))
		];

		return $drops;
	}
}
