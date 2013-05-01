<?php
/**
 * The RangeIterator allows to iterate over a range of numbers, from low to high
 *
 * Instead of a large array, an iterator can be used.
 */

require(__DIR__ . '/../src/autoload.php');

$range = new RangeIterator(3, 23);

foreach($range as $index => $number) {
    printf("%02d: %' 2s\n", $index, $number);
}


class SeekableRangeIterator extends RangeIterator implements SeekableIterator
{
}

$sr = new SeekableRangeIterator(2, 2000);
$debug = new SeekableDebugIterator($sr);
$paging = new LimitIterator($debug, 1988, 5);
foreach($paging as $index => $number) {
    printf("%02d: %' 2s\n", $index, $number);
}
