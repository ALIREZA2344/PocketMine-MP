<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
*/

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\math\AxisAlignedBB;
use pocketmine\Player;

class EndPortalFrame extends Solid{

	protected $id = self::END_PORTAL_FRAME;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getLightLevel(){
		return 1;
	}

	public function getName(){
		return "End Portal Frame";
	}

    public function canBeActivated(){
        return true;
    }

	public function getHardness(){
		return -1;
	}

	public function getResistance(){
		return 18000000;
	}

	public function isBreakable(Item $item){
		return false;
	}

	protected function recalculateBoundingBox(){

		return new AxisAlignedBB(
			$this->x,
			$this->y,
			$this->z,
			$this->x + 1,
			$this->y + (($this->getDamage() & 0x04) > 0 ? 1 : 0.8125),
			$this->z + 1
		);
	}

    public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
        $faces = [
            0 => 3,
            1 => 0,
            2 => 1,
            3 => 2,
        ];
        $this->meta = $faces[$player instanceof Player ? $player->getDirection() : 0];
        $this->getLevel()->setBlock($block, $this, true, true);
        return true;
    }

    public function onActivate(Item $item, Player $player = null){
        if(($this->getDamage() & 0x04) === 0 && $player instanceof Player){
            if($item->getId() === Item::ENDER_EYE){
                $this->setDamage($this->getDamage() + 4);
                $this->getLevel()->setBlock($this, $this, true, true);
                $this->createPortal();
                return true;
            }
        }

        return false;
    }

    private function createPortal(){
        return;
    }
}