<?php

namespace Scraper\Page\Visma;

use DOMDocument;
use DOMXPath;
//use Exception;

use Scraper\Page;
use Scraper\Page\Visma\Categories\CategoryList;

class Categories extends Page {

    private array $_category_links;

    protected function _scrape() : void
    {
        $dom = new DOMDocument();
        $html = $this->_getPageHtml();

        // suppress warnings - loadHTML will complain about the html loade
        // we don't care about this since we are just scraping the page
        error_reporting(E_ALL ^ E_WARNING);
        $dom->loadHTML($html);
        $finder = new DOMXPath($dom);

        $category_finder = new CategoryList();
        $nodes = $category_finder->queryCollection($finder);
        $this->_category_links = (array) $category_finder->getAttribute($nodes, 'href');
    }


    public function toJson() : string {
        return \json_encode($this->toArray(), \JSON_PRETTY_PRINT | \JSON_UNESCAPED_UNICODE);
    }

    public  function toArray() {
        $this->_scrape();
        return $this->_category_links;
    }

    public function getCategoryPaths() {
        $this->_scrape();
        return $this->_category_links;
    }

    // public function toCsv() : string {

    // }

}