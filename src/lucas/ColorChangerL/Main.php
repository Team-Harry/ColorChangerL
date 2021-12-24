<?php

namespace lucas\ColorChangerL;

use lucas\ColorChangerL\Form\ColorChangerForm;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\item\Item;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener
{
    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool
    {
        if($command->getName() == "색변환")
        {
            if($sender instanceof Player)
            {
                $id = $sender->getInventory()->getItemInHand()->getId();
                if($id == 241 OR $id == 160 OR $id == 35 OR $id == 171 OR $id == 237 OR $id == 236 OR $id == 159)
                {
                    $item = $sender->getInventory()->getItemInHand();
                    $sender->sendForm(new ColorChangerForm($sender->getInventory()->getItemInHand()->getId(), $sender->getInventory()->getItemInHand()->getMeta(), array_sum(array_map(function(Item $item): int{ return $item->getCount(); }, $sender->getInventory()->all($item)))));
                    return true;
                }
                $sender->sendMessage('§b[Color] 색 변환 가능 블록 : 스테인드글라스, 스테인드글라스 판유리, 양털, 카펫, 콘크리트 가루, 콘크리트, 테라코타');
                return true;
            }
        }
        return true;
    }
}