<?php

use Scraper\Visma\Product\Product;


require_once(__DIR__ . '/../src/Scraper/Visma/Product.php');


$urls = [
    "https://www.spengummimannen.se/shop/product/slaktpistol-blitz-med-tillbehor",
    "https://www.spengummimannen.se/shop/product/paddel-enhand",
    "https://www.spengummimannen.se/shop/product/reservgumm-till-rund-skrapa-66cm",
    "https://www.spengummimannen.se/shop/product/huv-sparkbage",
    "https://www.spengummimannen.se/shop/product/halsrem-bla-gul",
    "https://www.spengummimannen.se/shop/product/juverharbrannare",
    "https://www.spengummimannen.se/shop/product/elpafosare"
];


foreach($urls as $url) {
    $product = new Product($url);
    var_dump($product->toJson());
}