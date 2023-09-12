<?php

namespace Scraper\Page\Visma\Categories;

use Scraper\Element;

class CategoryList extends Element {

    protected function _getXpathSelector() : string {
        $ul = "ul[contains(@class, 'nav') and contains(@class, 'mainmenu')]";
        $li = "li[contains(@class, 'nav-item') and not(contains(@class, 'hasSubmenu'))]";
        $a = "a[not(contains(@class, 'hasChildren')) and not(contains(text(), 'Startsida'))]";
        return "//$ul//$li/$a";
    }
}