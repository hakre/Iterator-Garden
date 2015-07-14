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
 * @covers ForeachIterator
 */
class ForeachIteratorTest extends ForeachIteratorBaseTest
{
    /**
     * @test
     *
     * @dataProvider provideForeachAbleSamples
     */
    public function creation($foreachAble, $valid)
    {
        $this->helperTestConstructor('ForeachIterator', $foreachAble, $valid);
    }

    /**
     * @test
     */
    public function staticUnits()
    {
        $array    = array('foo' => 'bar');
        $object   = (object)$array;
        $expected = array_values($array);

        # iterator should always pass through
        $subject     = new EmptyIterator();
        $traversable = ForeachIterator::getTraversable($subject);
        $this->assertInstanceOf('Traversable', $traversable);
        $this->assertIterationValues(array(), $subject);

        $iterator = ForeachIterator::getIterator($subject);
        $this->assertInstanceOf('Iterator', $iterator);
        $this->assertIterationValues(array(), $subject);

        # array needs conversion
        $traversable = ForeachIterator::getTraversable($array);
        $this->assertInstanceOf('Traversable', $traversable);
        $this->assertIterationValues($expected, $traversable);

        $iterator = ForeachIterator::getIterator($array);
        $this->assertInstanceOf('Iterator', $iterator);
        $this->assertIterationValues($expected, $iterator);

        # IteratorAggregate doesn't for Traversable but for Iterator
        $aggregate   = new ArrayObject($object);
        $traversable = ForeachIterator::getTraversable($aggregate);
        $this->assertSame($aggregate, $traversable);
        $this->assertIterationValues($expected, $traversable);

        $iterator = ForeachIterator::getIterator($aggregate);
        $this->assertInstanceOf('Iterator', $iterator);
        $this->assertIterationValues($expected, $iterator);
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage boolean is not foreachable
     */
    public function getTraversableException()
    {
        ForeachIterator::getTraversable(false);
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage boolean is not foreachable
     */
    public function getIteratorException()
    {
        ForeachIterator::getIterator(false);
    }
}
