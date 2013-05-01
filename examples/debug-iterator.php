<?php
/**
 * The DebugIterator provides notices while iterating which is useful to demonstrate
 * how iterators work.
 */

require('../src/autoload.php');

function_exists('xdebug_disable') && xdebug_disable();
ini_set('log_errors', 0);
ini_set('display_errors', 1);
error_reporting(~0);

$array = range('a', 'c');
$it = new ArrayIterator($array);
echo "\n== Standard Foreach Example ==\n";
foreach($it as $value) {
    echo $value, "\n";
}

$debug = new DebugIterator($it);

echo "\n== Debug Foreach Example ==\n";
foreach($debug as $value) {
    echo $value, "\n";
}

echo "\n== Debug Foreach W/ Key Example ==\n";
foreach($debug as $key => $value) {
    echo $value, "\n";
}

echo "\n== Iterator Count Example ==\n";
printf("Count: %d\n", iterator_count($debug));
