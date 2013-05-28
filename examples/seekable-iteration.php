<?php
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
