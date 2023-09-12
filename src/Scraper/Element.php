<?php

namespace Scraper;

use DOMXPath;
use Exception;
use DOMNode;
use DOMNodeList;

abstract class Element {
    const TAG_DIV = 'div';
    const TAG_LI = 'li';
    const TAG_SPAN = 'span';

    protected function _classByXpath(string $class, string $element_type = '*') : string
    {
        return "//{$element_type}[contains(@class, '{$class}')]";
    }

    protected function _getXPathClassSelector(...$classes) {
        $str = '';

        foreach($classes as $class) {
            $str .= "//*[contains(@class, '{$class}')]";
        }

        return $str;
    }


    public function query(DOMXPath $finder) {
        $nodes = $finder->query($this->_getXpathSelector());

        if($nodes === false) {
            throw new Exception('FAILED TO SCRAPE');
        }

        return $this->_getNodeText($nodes[0]);
    }

    private function _getNodeText(DOMNode $node) {
        return trim($node->nodeValue);
    }

    public function queryCollection(DOMXpath $finder) {
        $selector = $this->_getXpathSelector();
        $nodes = $finder->query($selector);

        if($nodes === false) {
            echo "\n selector: $selector \n";
            throw new Exception('FAILED TO SCRAPE');
        }

        return $nodes;
    }

    public function queryLinks(DOMXPath $finder) {
        $nodes = $this->queryCollection($finder);

        return $this->getAttribute($nodes, 'href');
    }

    public function getAttribute(DOMNodeList $nodes, $attribute) {
          $links = [];

        foreach($nodes as $node) {
            $link = $node->getAttribute($attribute);
            $parts = explode('?', $link);
            $links[] = $parts[0];
        }

        return $links;
    }

    abstract protected function _getXpathSelector(): string;
}