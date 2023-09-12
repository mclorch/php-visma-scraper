<?php

namespace Scraper\Page\Visma\Product;

use DOMXPath;
use Scraper\Element;

class Title extends Element {
    const CLASS_NAME = 'ArticleDetails';

    protected function _getXpathSelector() : string {
        $div =  $this->_classByXpath(self::CLASS_NAME, self::TAG_DIV);
        return "$div/h1/span/text()";
    }

    public function query(DOMXPath $finder) {
        $title = parent::query($finder);
        return "$title - INTE REDIGERAD";
    }
}