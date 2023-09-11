<?php

abstract class Element {
    const TAG_DIV = 'div';
    const TAG_LI = 'li';
    const TAG_SPAN = 'span';

    protected function _classByXpath(string $class, string $element_type = '*') : string
    {
        return "//{$element_type}[contains(@class, '{$class}')]";
    }

    public function query(DOMXPath $finder) {
        $nodes = $finder->query($this->_getXpathSelector());

        if($nodes === false) {
            throw new Exception('FAILED TO SCRAPE');
        }

        $text = $nodes[0]->nodeValue;
        return trim($text);
    }

    abstract protected function _getXpathSelector(): string;
}