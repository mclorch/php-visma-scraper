<?php

namespace Scraper\Visma\Product;

use DOMDocument;
use DOMXPath;
use Scraper\Page;
use Exception;
use Sku;
use Title;


require(__DIR__ . '/../Page.php');
require(__DIR__ . '/Product/Selectable/Sku.php');
require(__DIR__ . '/Product/Selectable/Title.php');

class Product extends Page {

    private ?string $_title;
    private ?string $_sku;
    private string $_handle;

    public function __construct($url) {
        parent::__construct($url);

        if(!$this->_isProductPage()) {
            throw new Exception("Not product page: $url");
        }

        $this->_handle = $this->_getHandle();
    }

    private function _getHandle() : string
    {
        $url = strtok($this->_getUrl(), '?');
        $parts = explode('/', $url);
        return array_pop($parts);
    }

    private function _isProductPage() : bool
    {
        return str_contains($this->_getUrl(), '/product/');
    }

    protected function _scrape() : void
    {
        $dom = new DOMDocument();
        $html = $this->_getPageHtml();

        // suppress warnings - loadHTML will complain about the html loade
        // we don't care about this since we are just scraping the page
        error_reporting(E_ALL ^ E_WARNING);
        $dom->loadHTML($html);
        $finder = new DOMXPath($dom);

        $this->_title = (new Title())->query($finder);
        $this->_sku = (new Sku($finder))->query($finder);
    }


    public function toJson() : string {
        $this->_scrape();
        return \json_encode($this->_toArray(), \JSON_PRETTY_PRINT | \JSON_UNESCAPED_UNICODE);
    }

    protected function _toArray() {
        return [
            'title' => $this->_title,
            'sku' => $this->_sku,
            'handle' => $this->_handle,
        ];
    }

    // public function toCsv() : string {

    // }

}