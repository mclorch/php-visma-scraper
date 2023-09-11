
<?php

require_once(__DIR__ . '/../Element.php');

class Title extends Element{
    const CLASS_NAME = 'ArticleDetails';

    protected function _getXpathSelector() : string {
        $div =  $this->_classByXpath(self::CLASS_NAME, self::TAG_DIV);
        return "$div/h1/span/text()";
    }
}