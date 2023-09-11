<?php

abstract class Element {
    const TAG_DIV = 'div';
    const TAG_LI = 'li';

    protected function _classByXpath(string $class, string $element_type = '*') : string
    {
        return "//{$element_type}[contains(@class, '{$class}')]";
    }

    public function query(DOMXPath $finder) {
        $nodes = $finder->query($this->_getXpathSelector());

        if($nodes === false) {
            throw new Exception('FAILED TO SCRAPE');
        }

        return $nodes[0]->nodeValue;
        //$trimmed = trim($text);
        //return utf8_encode($trimmed);
    }

    abstract protected function _getXpathSelector(): string;
}