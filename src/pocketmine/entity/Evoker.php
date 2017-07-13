<?php
namespace pocketmine\entity;

use pocketmine\item\Item as ItemItem;
use pocketmine\network\mcpe\protocol\AddEntityPacket;
use pocketmine\Player;

class Evoker extends Monster{
    const NETWORK_ID = 104;
	
	protected $exp_min = 10;
	protected $exp_max = 10;
	protected $maxHealth = 24;

    public function initEntity(){
        parent::initEntity();
    }

 	public function getName(){
        return "Evoker";
    }

	public function getCodeName(){
		return "evocation_illager";
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
			//ItemItem::get(ItemItem::TOTEM_OF_UNDYING),
			ItemItem::get(ItemItem::EMERALD, 0, mt_rand(0, 1))
		];
	}
}
