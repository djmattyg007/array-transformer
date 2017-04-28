<?php

require(__DIR__ . "/src/ArrayTransformer.php");

use MattyG\ArrayTransformer\ArrayTransformer;

$t = new ArrayTransformer();
$t->values()
    ->diff(array("a", "c"), array("e"))
    ->mergeLeft(array("m", "n"));

$input = array("x" => "a", "y" => "b", "z" => "c");
$output = $t->apply($input);
var_dump($output);
