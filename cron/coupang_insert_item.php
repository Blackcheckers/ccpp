#!/usr/local/bin/php
<?php
include "../common.php";
use CCPP\Coupang\CoupangAPI;
use CCPP\Coupang\Post;

$coupangAPI = $_APP->make(CoupangAPI::class);
$post = $_APP->make(Post::class);
$productArr = $coupangAPI->productArr;
$cp = [
    'bo_table' => 'product',
    'resource' => '1012',
    'method' => 'GET',
    'count' => '3',
];

if(isset($cp)){
    $resource = $cp['resource'];
    $method   = $cp['method'];
    $count    = empty($cp['count']) ? '10' : $cp['count'];
    $cpItems = $coupangAPI->getBestcategories("$resource", 'GET', $count);
    $post->init(sql_real_escape_string($cp['bo_table']));
    $result = $post->storeItems($cpItems->data);
    var_dump($result);
}