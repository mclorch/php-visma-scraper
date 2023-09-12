<?php

namespace Scraper\Page\Visma;

use DOMDocument;
use DOMXPath;
use Exception;

use Scraper\{
    Page,
    Page\Visma\Product\Price,
    Page\Visma\Product\Sku,
    Page\Visma\Product\Title
};

class Product extends Page {
    private const BRAND = 'varumärke';
    private const TYPE = 'typ';
    private const CORRESPONDS_TO = 'motsvarar';
    private const DESCRIPTION = 'beskrivning';
    private const AMOUNT_PER_PACKAGE = 'antal/frp';
    private const MEASURES = 'mått';

    private ?string $_title;
    private ?string $_sku;
    private string $_handle;
    private ?string $_variant_price;

    public function __construct($url) {
        parent::__construct($url);

        if (!$this->_isProductPage()) {
            throw new Exception("Not product page: $url");
        }

        $this->_handle = $this->_getHandle();
    }

    private function _getHandle(): string {
        $url = strtok($this->_getUrl(), '?');
        $parts = explode('/', $url);
        return array_pop($parts);
    }

    protected function _scrape(): void {
        $dom = new DOMDocument();
        $html = $this->_getPageHtml();

        // suppress warnings - loadHTML will complain about the html loade
        // we don't care about this since we are just scraping the page
        error_reporting(E_ALL ^ E_WARNING);
        $dom->loadHTML($html);
        $finder = new DOMXPath($dom);

        $this->_title = (new Title())->query($finder);
        $this->_sku = (new Sku($finder))->query($finder);
        $this->_variant_price = (new Price())->query($finder);
    }


    public function toJson(): string {
        return \json_encode($this->toArray(), \JSON_PRETTY_PRINT | \JSON_UNESCAPED_UNICODE);
    }

    public function toArray() {
        $this->_scrape();

        return [
            'Handle' => $this->_handle,
            'Body (HTML)' => '',
            'Title' => $this->_title,
            'Vendor' => '',
            'Product Category' => 1, // this may need altered?
            'Type' => '', //$this->_type,
            'Tags' => '',
            'Published' => '',
            'Option1 Name' => "",
            'Option1 Value' => "",
            'Option2 Name' => "",
            'Option2 Value' => "",
            'Option3 Name' => "",
            'Option3 Value' => "",
            'Variant SKU' => $this->_sku,
            'Variant Grams' => "",
            'Variant Inventory Tracker' => "",
            'Variant Inventory Qty' => "",
            'Variant Inventory Policy' => "continue",
            'Variant Fulfillment Service' => "manual",
            'Variant Price' => $this->_variant_price,
            'Variant Compare At Price' => "",
            'Variant Requires Shipping' => "",
            'Variant Taxable' => "",
            'Variant Barcode' => "",
            'Image Src' => "",
            'Image Position' => "",
            'Image Alt Text' => "",
            'Gift Card' => "",
            'SEO Title' => "",
            'SEO Description' => "",
            'Google Shopping / Google Product Category' => "",
            'Google Shopping / Gender' => "",
            'Google Shopping / Age Group' => "",
            'Google Shopping / MPN' => "",
            'Google Shopping / AdWords Grouping' => "",
            'Google Shopping / AdWords Labels' => "",
            'Google Shopping / Condition' => "",
            'Google Shopping / Custom Product' => "",
            'Google Shopping / Custom Label 0' => "",
            'Google Shopping / Custom Label 1' => "",
            'Google Shopping / Custom Label 2' => "",
            'Google Shopping / Custom Label 3' => "",
            'Google Shopping / Custom Label 4' => "",
            'Variant Image' => "",
            'Variant Weight Unit' => "",
            'Variant Tax Code' => "",
            'Cost per item' => "",
            'Price / International' => "",
            'Compare At Price / International' => "",
            'Status' => "active", // assuming all products visible to scraper are active
        ];
    }

    // public function toCsv() : string {

    // }

    public static function getHeaders() {

        return [
            'Handle',
            'Body (HTML)',
            'Title',
            'Vendor',
            'Product Category',
            'Type',
            'Tags',
            'Published',
            'Option1 Name',
            'Option1 Value',
            'Option2 Name',
            'Option2 Value',
            'Option3 Name',
            'Option3 Value',
            'Variant SKU',
            'Variant Grams',
            'Variant Inventory Tracker',
            'Variant Inventory Qty',
            'Variant Inventory Policy' => "continue",
            'Variant Fulfillment Service' => "manual",
            'Variant Price',
            'Variant Compare At Price',
            'Variant Requires Shipping',
            'Variant Taxable',
            'Variant Barcode',
            'Image Src',
            'Image Position',
            'Image Alt Text',
            'Gift Card',
            'SEO Title',
            'SEO Description',
            'Google Shopping / Google Product Category',
            'Google Shopping / Gender',
            'Google Shopping / Age Group',
            'Google Shopping / MPN',
            'Google Shopping / AdWords Grouping',
            'Google Shopping / AdWords Labels',
            'Google Shopping / Condition',
            'Google Shopping / Custom Product',
            'Google Shopping / Custom Label 0',
            'Google Shopping / Custom Label 1',
            'Google Shopping / Custom Label 2',
            'Google Shopping / Custom Label 3',
            'Google Shopping / Custom Label 4',
            'Variant Image',
            'Variant Weight Unit',
            'Variant Tax Code',
            'Cost per item',
            'Price / International',
            'Compare At Price / International',
            'Status',
        ];
    }
}
