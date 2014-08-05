<?php
/*
 * Iterator Garden - Let Iterators grow like flowers in the garden.
 * Copyright 2013, 1014 hakre <http://hakre.wordpress.com/>
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
 * The ChunkIterator allows to iterate over chunks of an iteration in pair with IteratorChunk.
 *
 * IteratorChunk as stand-alone allows to get a chunk out of an iteration.
 */

require('../src/autoload.php');

$range = new RangeIterator(1, 10);

$chunks = new ChunkIterator($range, 3);

echo "chunks as nested foreach fixed size:\n";

foreach ($chunks as $index => $chunk) {
    echo " chunk #$index:\n";
    foreach ($chunk as $key => $value) {
        echo "  $key => $value\n";
    }
}

echo "diverse chunks of different size:\n";

$range = new RangeIterator(1, 10);
$range->rewind();

echo " chunk #0 (3):\n";
foreach (new IteratorChunk($range, 3) as $key => $value) {
    echo "  $key => $value\n";
}

echo " chunk #1 (5):\n";
foreach (new IteratorChunk($range, 5) as $key => $value) {
    echo "  $key => $value\n";
}

echo " chunk #2 (3):\n";
foreach (new IteratorChunk($range, 3) as $key => $value) {
    echo "  $key => $value\n";
}
