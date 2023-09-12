<?php

namespace Scraper\Page\Visma\Category;

use Scraper\Element;

class ProductList extends Element {

    protected function _getXpathSelector() : string {
        // '.articleCategoryList .ArticleOverview a.moreInfo'

        return $this->_getXPathClassSelector('articleCategoryList', 'ArticleOverview', 'moreInfo');
;
    }
}