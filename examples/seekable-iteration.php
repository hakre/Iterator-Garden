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
 * The SeekableIteration class is an Iterator that allows to seek while iterating
 */

require(__DIR__ . '/../src/SeekableIteration.php');

$array = new ArrayIterator(range('A', 'J')); # 10 Characters A to J

// create SeekableIteration
$seek = new SeekableIteration($array);

// seek inside foreach
foreach ($seek as $index => $char) {
    echo $char, $index < 8 ? ", " : '';
    // skip every second character
    $seek->seek($seek->getIndex() + 1);
}
echo "\n";


// set a starting position to seek for the next iteration
$seek->seekStart(3);

foreach ($seek as $index => $char) {
    echo $char, $index < 7 ? ", " : '';

    if ($index === 5) {
        // seek but ignore next next()/rewind()
        $seek->seek(9, TRUE);
    }
}
echo "\n";
