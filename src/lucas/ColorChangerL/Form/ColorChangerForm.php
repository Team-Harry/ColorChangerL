<?php

namespace lucas\ColorChangerL\Form;

use Harry\FormAPI\FormAPI;
use pocketmine\item\ItemFactory;
use pocketmine\player\Player;

class ColorChangerForm extends FormAPI
{
    protected int $itemid;
    protected int $itemmeta;
    protected int $itemcount;
    protected array $colorlist;
    protected array $itemlist;
    public function __construct(int $itemid, int $itemmeta, int $itemcount)
    {
        parent::__construct(self::FORM_TYPE_CUSTOM, '색 변환 UI');
        $this->itemid = $itemid;
        $this->itemmeta = $itemmeta;
        $this->itemcount = $itemcount;
        $this->colorlist = [
            '흰색',
            '주황색',
            '자홍색',
            '밝은 파란색',
            '노란색',
            '연두색',
            '분홍색',
            '회색',
            '밝은 회색',
            '청록색',
            '보라색',
            '파란색',
            '갈색',
            '녹색',
            '빨간색',
            '검은색'
        ];
        $this->itemlist = [
            '241' => '스테인드글라스',
            '160' => '스테인드글라스 판유리',
            '35' => '양털',
            '171' => '카펫',
            '237' => '콘크리트 가루',
            '236' => '콘크리트',
            '159' => '테라코타',
        ];
    }

    public function setReady() : void
    {
        $dropdownlist = [];
        for($i = 0; $i <= 15; $i++)
        {
            $dropdownlist[] = $this->colorlist[$i].' '.$this->itemlist[$this->itemid];
        }
        $this->addSlider('변환할 아이템 개수를 선택해주세요', 1, $this->itemcount, 1, $this->itemcount);
        $this->addDropdown($this->colorlist[$this->itemmeta].' '.$this->itemlist[$this->itemid].'을(를) 무엇으로 변환할지 선택해주세요', $dropdownlist, $this->itemmeta);
    }

    public function handleResponse(Player $player, $data) : void
    {
        if(isset($data))
        {
            $player->getInventory()->removeItem(ItemFactory::getInstance()->get($this->itemid, $player->getInventory()->getItemInHand()->getMeta(), $data[0]));
            if($player->getInventory()->canAddItem(ItemFactory::getInstance()->get($this->itemid, $data[1], $data[0])))
            {
                $player->getInventory()->addItem(ItemFactory::getInstance()->get($this->itemid, $data[1], $data[0]));
                $player->sendMessage('§b[Color] '.$this->colorlist[$this->itemmeta].' '.$this->itemlist[$this->itemid].' '.$data[0].'개가 '.$this->colorlist[$data[1]].' '.$this->itemlist[$this->itemid].' '.$data[0].'개로 변환됐습니다.');
            } else
            {
                $player->getInventory()->addItem(ItemFactory::getInstance()->get($this->itemid, $player->getInventory()->getItemInHand()->getMeta(), $data[0]));
                $player->sendMessage('§b[Color] '.'인벤토리 공간이 부족합니다.');
            }
        }
    }
}