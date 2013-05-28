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
 * When does the NoRewindIterator rewind the inner Iterator?
 */

require(__DIR__ . '/../src/autoload.php');

/**
 * Class OneTimeRewindIterator
 */
class OneTimeRewindIterator extends NoRewindIterator
{
    private $didRewind = FALSE;

    public function rewind()
    {
        if ($this->didRewind) return;

        $this->didRewind = TRUE;
        $this->getInnerIterator()->rewind();
        if ($this->getInnerIterator()->valid()) {
            $this->getInnerIterator()->current();
            $this->getInnerIterator()->key();
        }
    }
}

$iterator = new RangeIterator(1, 2);
$debug    = new DebugIteratorDecorator($iterator);
$stacked  = new OneTimeRewindIterator($debug);
$debug    = new DebugIteratorDecorator($stacked);
foreach ($debug as $value) {
    echo $value, "\n";
}
return;


$iterator = new RangeIterator(1, 1);
$debug    = new DebugIteratorDecorator($iterator);
$noRewind = new OneTimeRewindIterator($debug);

echo "first foreach:\n";

foreach ($noRewind as $value) {
    echo "iteration value: $value\n";
}

echo "\n\$calling noRewind->getInnerIterator()->rewind():\n";

$noRewind->getInnerIterator()->rewind();

echo "\nsecond foreach:\n";

foreach ($noRewind as $value) {
    echo "iteration value: $value\n";
}
