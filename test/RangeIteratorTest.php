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

class RangeIteratorTest extends IteratorTestCase
{

    public function testRange()
    {
        $from = 0;
        $to   = 1;
        $step = -.1;

        $this->assertRangeIterator($from, $to, $step);
        $this->assertRangeIterator($to, $from, $step);
    }

    public function testRangeWithSingleElement()
    {
        $this->assertRangeIterator(1, 1);
        $this->assertRangeIterator(1, 1, 1);
    }

    private function assertRangeIterator($from, $to, $step = NULL)
    {
        $refl       = new ReflectionClass('RangeIterator');
        $iterator   = $refl->newInstanceArgs(array($from, $to, $step));
        $rangeArray = new ArrayIterator(range($from, $to, $step));

        $this->assertIteration($rangeArray, $iterator);
    }
}
