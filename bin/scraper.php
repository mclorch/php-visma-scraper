<?php

use Scraper\Page\Visma\Categories;
use Scraper\Page\Visma\Category;
use Scraper\Page\Visma\Product;

require_once __DIR__ . '/../vendor/autoload.php';

$base = 'https://www.spengummimannen.se'; // todo - make this user input

$categories = new Categories($base);

$file = getResultFilePath();
$fp = fopen($file, 'a');

fputcsv($fp, Product::getHeaders());

foreach($categories->getCategoryPaths() as $path) {
    echo "\n -- scraping $path... --- \n";

    $product_links = getCategoryProductLinks($path);
    saveProducts($product_links, $fp);

    echo "\n -- Saved all the products from $path --- \n\n";
};

fclose($fp);
echo "\n\nDONE! Successfully scaped all categories. \n\n";

function getCategoryProductLinks($params) {
    $url  = getUrlWithPath($params);
    return (new Category($url))->getProductLinks();
}

function getUrlWithPath($path) {
    return "https://www.spengummimannen.se{$path}";
}


function saveProducts($product_paths, $fp) {

    foreach($product_paths as $path) {
        $product_url = getUrlWithPath($path);
        $product = new Product($product_url);
        // $row = array_values($product->toArray());

        // if(filesize($file) === 0) {
        //     // first line is headers
        //     $row = array_keys($product->toArray());
        // }

        fputcsv($fp, $product->toArray());
    }
}

function getResultFilePath() {
    $timestamp = time();
    return __DIR__ . "/../tmp/result-$timestamp.csv";
}



 /** Once the data is written it will be saved in the path given */