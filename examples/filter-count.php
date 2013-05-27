<?php
/**
 * CounteFilterIterator Example
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
