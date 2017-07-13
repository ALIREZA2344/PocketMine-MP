<?php
namespace pocketmine\entity;

use pocketmine\item\Item as ItemItem;
use pocketmine\network\mcpe\protocol\AddEntityPacket;
use pocketmine\Player;

class IronGolem extends Animal{
    const NETWORK_ID = 20;

	protected $maxHealth = 100;

    public function initEntity(){
        parent::initEntity();
    }

    public function getName(){
        return "Iron Golem";
    }

	public function getCodeName(){
		return "iron_golem";
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
            ItemItem::get(ItemItem::IRON_INGOT, 0, mt_rand(3, 5)),
            ItemItem::get(ItemItem::POPPY, 0, mt_rand(0, 2))
        ];
    }

	public function isLeashableType(){
		return false;
	}
}