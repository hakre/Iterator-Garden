<?php
/*
 * Iterator Garden - Let Iterators grow like flowers in the garden.
 * Copyright 2013, 2014, 2015 hakre <http://hakre.wordpress.com/>
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
 * Class RangeIteratorTest
 *
 * @covers RangeIterator
 */
class RangeIteratorTest extends IteratorTestCase
{
    /**
     * @test
     */
    public function creation()
    {
        $this->assertInstanceOf('RangeIterator', new RangeIterator("44", 2));
        $this->assertInstanceOf('RangeIterator', new RangeIterator(44.4, 2));
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Step must be integer or float, boolean given
     */
    public function creationWithInvalidStep()
    {
        $edge = new RangeIterator(1, 2, null);
        $this->assertInstanceOf('RangeIterator', $edge);

        new RangeIterator(1, 2, false);
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Low must be a number or a numeric string, NULL given
     */
    public function creationWithInvalidFrom()
    {
        new RangeIterator(null, 2, null);
    }

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

    /**
     * @test
     */
    public function seeking()
    {
        $range = new RangeIterator(1, 4);
        $range->seek(0);
        $this->assertTrue($range->valid());
        $range->seek(3);
        $this->assertTrue($range->valid());
        $range->next();
        $this->assertFalse($range->valid(), 'precondition after next check');
        $range->seek(4);
        $this->assertFalse($range->valid());
    }

    private function assertRangeIterator($from, $to, $step = null)
    {
        $reflection = new ReflectionClass('RangeIterator');
        $iterator   = $reflection->newInstanceArgs(array($from, $to, $step));
        $rangeArray = new ArrayIterator(range($from, $to, $step));

        $this->assertIteration($rangeArray, $iterator);
    }
}
