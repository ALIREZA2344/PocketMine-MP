<?php

namespace pocketmine\entity;

use pocketmine\level\Level;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\protocol\AddEntityPacket;
use pocketmine\Player;

class Egg extends Projectile{
	const NETWORK_ID = 82;

	protected $gravity = 0.03;
	protected $drag = 0.01;

	public function __construct(Level $level, CompoundTag $nbt, Entity $shootingEntity = null){
		parent::__construct($level, $nbt, $shootingEntity);
	}

	public function onUpdate($currentTick){
		if($this->closed){
			return false;
		}
		
		$this->timings->startTiming();
		
		$hasUpdate = parent::onUpdate($currentTick);
		
		if($this->age > 1200 or $this->isCollided){
			$this->kill();
			$hasUpdate = true;
			/*if(mt_rand(1, 8) === 1){
				$chicken = null;
				$level = $this->chunk;
				
				if(!($level instanceof Level)){
					return false;
				}
				
				$nbt = new CompoundTag("", ["Pos" => new ListTag("Pos", [new DoubleTag("", $this->getX()),new DoubleTag("", $this->getY()),new DoubleTag("", $this->getZ())]),
						"Motion" => new ListTag("Motion", [new DoubleTag("", 0),new DoubleTag("", 0),new DoubleTag("", 0)]),"Rotation" => new ListTag("Rotation", [new FloatTag("", mt_rand(0, 360)),new FloatTag("", 0)])]);
				$nbt->Age = new StringTag("Age", 0);
				$chicken = Entity::createEntity("Chicken", $level, $nbt);
				if($chicken instanceof Entity){
					$chicken->setDataProperty(14, self::DATA_TYPE_BYTE, 0);
					$chicken->spawnToAll();
				}
			}*/
		}
		
		$this->timings->stopTiming();
		
		return $hasUpdate;
	}

	public function getName(){
		return "Egg";
	}

	public function getCodeName(){
		return "egg";
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
		$pk->metadata = $this->dataProperties;
		$player->dataPacket($pk);

		parent::spawnTo($player);
	}
}
