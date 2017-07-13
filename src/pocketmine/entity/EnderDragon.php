<?php
namespace pocketmine\entity;

use pocketmine\network\mcpe\protocol\AddEntityPacket;
use pocketmine\Player;

class EnderDragon extends Monster implements ProjectileSource{
    const NETWORK_ID = 53;
	
	protected $exp_min = 12500;
	protected $exp_max = 12500;
	protected $maxHealth = 200;

    public function initEntity(){
        parent::initEntity();
    }

 	public function getName(){
        return "Ender Dragon";
    }

	public function getCodeName(){
		return "ender_dragon";
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
}
