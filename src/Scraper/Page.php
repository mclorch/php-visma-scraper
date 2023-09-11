<?php

namespace Scraper;

abstract class Page {
    private string $_url;

    public function __construct($url)
    {
        $this->_url = $url;
    }


    protected function _getUrl() : string
    {
        return $this->_url;
    }

    protected function _getPageHtml() : string {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 200);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_URL, $this->_getUrl());

        return curl_exec($ch);
    }

    abstract protected function _scrape() : void;
    abstract public function toJson(): string;
}