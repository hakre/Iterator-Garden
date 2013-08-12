<?php
/*
 * Iterator Garden - Let Iterators grow like flowers in the garden.
 * Copyright 2013, 2014 hakre <http://hakre.wordpress.com/>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * The DebugIterator provides notices while iterating which is useful to demonstrate
 * how iterators work.
 */

require(__DIR__ . '/../src/autoload.php');

function_exists('xdebug_disable') && xdebug_disable();
ini_set('log_errors', 0);
ini_set('display_errors', 1);
error_reporting(~0);

$array = range('a', 'c');
$it    = new ArrayIterator($array);
echo "\n== Standard Foreach Example ==\n";
foreach ($it as $value) {
    echo $value, "\n";
}

// $debug = new DebugIteratorDecorator($it);
$debug = DebugIteratorEmitter::createFor($it)
    ->registerOutput()
    ->getDebugIterator();

echo "\n== Debug Foreach Example ==\n";
foreach ($debug as $value) {
    echo $value, "\n";
}

echo "\n== Debug Foreach W/ Key Example ==\n";
foreach ($debug as $key => $value) {
    echo $key, ' => ', $value, "\n";
}

echo "\n== Iterator Count Example ==\n";
printf("Count: %d\n", iterator_count($debug));
