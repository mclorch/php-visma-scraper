<?php

namespace Scraper\Page\Visma\Product;

use Scraper\Element;

class Sku extends Element {

    const CLASS_NAME = 'artnr';

    protected function _getXpathSelector() : string {
        $li =  $this->_classByXpath(self::CLASS_NAME, self::TAG_LI);
        return "$li/span[position()=2]";
    }
}