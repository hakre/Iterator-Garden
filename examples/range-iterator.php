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
 * The RangeIterator allows to iterate over a range of numbers, from low to high
 *
 * Instead of a large array, an iterator can be used.
 */

require(__DIR__ . '/../vendor/autoload.php');

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
