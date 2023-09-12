<?php

namespace Scraper\Page\Visma\Product;

use Scraper\Element;

class Price extends Element {

    const CLASS_NAME = 'currency';

    protected function _getXpathSelector() : string {
        $li =  $this->_classByXpath(self::CLASS_NAME, self::TAG_SPAN);
        return "$li/span";
    }
}