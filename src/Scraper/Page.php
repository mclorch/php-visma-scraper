<?php

namespace Scraper;

use DOMDocument;
use DOMXPath;
use Exception;

abstract class Page {
    private string $_url;
    private $_ch;

    public function __construct($url)
    {
        $this->_url = $url;
    }


    protected function _getUrl() : string
    {
        return $this->_url;
    }

    protected function _loadDOMXPath() : DOMXPath {
        $dom = new DOMDocument();
        $html = $this->_getPageHtml();

        // suppress warnings - loadHTML will complain about the html loade
        // we don't care about this since we are just scraping the page
        error_reporting(E_ALL ^ E_WARNING);
        $dom->loadHTML($html);
        return new DOMXPath($dom);
    }

    protected function _getPageHtml() : string {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 200);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_URL, $this->_getUrl());

        $html = curl_exec($ch);
        if($html === false) {
            throw new Exception('failed to send request! ' . $this->_getUrl());
        }
        $response_code = \curl_getinfo($ch,  CURLINFO_HTTP_CODE );
        if($response_code !== 200 ) {
            throw new Exception("Page returned response code $response_code");
        }

        return $html;
    }


    protected function _isProductPage() : bool
    {
        return str_contains($this->_getUrl(), '/product/');
    }


    abstract protected function _scrape() : void;
}