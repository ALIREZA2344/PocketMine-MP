<?php
namespace pocketmine\entity;

use pocketmine\item\Item as ItemItem;
use pocketmine\network\mcpe\protocol\AddEntityPacket;
use pocketmine\Player;

class Enderman extends Monster{
	const NETWORK_ID = 38;
	
	protected $exp_min = 5;
	protected $exp_max = 5;
	protected $maxHealth = 40;

	public function initEntity(){
		parent::initEntity();
	}

	public function getName(){
		return "Enderman";
	}

	public function getCodeName(){
		return "enderman";
	}

	public function spawnTo(Player $player){
		$pk = new AddEntityPacket();
		$pk->type = self::NETWORK_ID;
		$pk->entityRuntimeId = $this->getId();
		$pk->x = $this->x;
		$pk->y = $this->y;
		$pk->z = $this->z;
		$pk->speedX = $this->motionX;
		$pk->speedY = $this->motionY;
		$pk->speedZ = $this->motionZ;
		$pk->yaw = $this->yaw;
		$pk->pitch = $this->pitch;
		$pk->metadata = $this->dataProperties;
		$player->dataPacket($pk);

		parent::spawnTo($player);
	}

	public function getDrops(){
		return [
			ItemItem::get(ItemItem::ENDER_PEARL, 0, mt_rand(0, 1))
			// holding Block
		];
	}

}
