<?php

namespace Scraper\Page\Visma;

use Scraper\Page;
use Scraper\Page\Visma\Category\ProductList;

class Category extends Page {
    private $_product_links;

    protected function _scrape() : void
    {
        $finder = $this->_loadDOMXPath();
        $this->_product_links = (new ProductList())->queryLinks($finder);
    }

    public function getProductLinks()
    {
        $this->_scrape();
        return $this->_product_links;
    }
}