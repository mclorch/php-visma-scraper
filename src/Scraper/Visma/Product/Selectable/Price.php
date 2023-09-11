<?php

require_once(__DIR__ . '/../Element.php');

class Price extends Element {

    const CLASS_NAME = 'currency';

    protected function _getXpathSelector() : string {
        $li =  $this->_classByXpath(self::CLASS_NAME, self::TAG_SPAN);
        return "$li/span";
    }
}