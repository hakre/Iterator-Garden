<?php
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
