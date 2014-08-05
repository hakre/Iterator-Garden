<?php
/*
 * Iterator Garden - Let Iterators grow like flowers in the garden.
 * Copyright 2013 hakre <http://hakre.wordpress.com/>
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
 * CountFilterIterator Example
 *
 * @link http://chat.stackoverflow.com/transcript/message/9641987#9641987
 */
require(__DIR__ . '/../src/autoload.php');

$array = array(
    array(1, 3, 4),
    array(1, 2),
);

foreach ($array as $value) {
    @list($a, $b, $c) = $value;
    var_dump($c);
}
// Output:
//   int(4)
//   NULL
// Problem:
//   Notice: Undefined offset: 2
// Task:
//   Filter out all values with a count not 3


$filtered = new CountFilterIterator($array, 3);
foreach ($filtered as $value) {
    list($a, $b, $c) = $value;
    var_dump($c);
}
// Output:
//   int(4)
// Problem:
//   Solved!
