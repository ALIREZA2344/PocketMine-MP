<?php

namespace pocketmine\entity;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\item\Item as ItemItem;
use pocketmine\network\mcpe\protocol\AddEntityPacket;
use pocketmine\Player;

class WitherSkeleton extends Monster implements ProjectileSource{
	const NETWORK_ID = 48;

	public $height = 2;
	public $width = 0.781;
	public $lenght = 0.875;

	protected $exp_min = 5;
	protected $exp_max = 5;
	protected $maxHealth = 20;

	public function initEntity(){
		parent::initEntity();
	}

	public function getName(): string{
		return "Wither Skeleton";
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
		$drops = [];
		if ($this->lastDamageCause instanceof EntityDamageByEntityEvent and $this->lastDamageCause->getEntity() instanceof Player){
			$drops = [
				ItemItem::get(ItemItem::COAL, 0, mt_rand(0, 1)),
				ItemItem::get(ItemItem::BONE, 0, mt_rand(0, 2))
			];
		}

		if ($this->lastDamageCause instanceof EntityDamageByEntityEvent and $this->lastDamageCause->getEntity() instanceof Creeper && $this->lastDamageCause->getEntity()->isPowered()){
			$drops = [
				ItemItem::get(ItemItem::SKULL, 1, 1)
			];
		}

		return $drops;
	}
}
