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
 * Class CartesianProductIteratorTest
 *
 * @covers CartesianProductIterator
 */
class CartesianProductIteratorTest extends IteratorTestCase
{
    public function testConstructor()
    {
        $it = new CartesianProductIterator();
        $this->assertInstanceOf('CartesianProductIterator', $it);
    }

    /**
     * @return array
     * @see testIteration
     */
    public function productsProvider()
    {
        return array(
            array(
                NULL,
                array(),
                array(),
                array()
            ),
            array(
                NULL,
                array(
                    array(0, 2),
                ),
                array(
                    array(0),
                    array(2),
                ),
                array(
                    array(0),
                    array(1),
                ),
            ),
            array(
                NULL,
                array(
                    array(0, 1),
                    array(2, 3),
                ),
                array(
                    array(0, 2),
                    array(0, 3),
                    array(1, 2),
                    array(1, 3),
                ),
            ),
            array(
                CartesianProductIterator::ORDER_LAST_FIRST,
                array(
                    array(0, 1),
                    array(2, 3),
                ),
                array(
                    array(0, 2),
                    array(0, 3),
                    array(1, 2),
                    array(1, 3),
                ),
            ),
            array(
                CartesianProductIterator::ORDER_FIRST_FIRST,
                array(
                    array(0, 1),
                    array(2, 3),
                ),
                array(
                    array(0, 2),
                    array(1, 2),
                    array(0, 3),
                    array(1, 3),
                ),
            ),
            array(
                NULL,
                array(
                    array(0, 1),
                    array(2),
                ),
                array(
                    array(0, 2),
                    array(1, 2),
                ),
                array(
                    array(0, 0),
                    array(1, 0),
                ),
            ),
        );
    }

    /**
     * @param int|null $orderMode
     * @param array $arrays
     * @param array $expected current values
     * @param array $expectedKeys
     *
     * @dataProvider productsProvider
     * @test
     */
    public function iteration($orderMode, $arrays, $expected, $expectedKeys = NULL)
    {
        $actual = new CartesianProductIterator($orderMode);

        foreach ($arrays as $array) {
            $actual->append(new ArrayIterator($array));
        }

        $this->assertIterationValues($expected, $actual);

        if ($expectedKeys) {
            $actual->rewind();
            $this->assertIterationKeys($expectedKeys, $actual);
        }

    }

    /**
     * @test
     */
    public function getArrayIterator()
    {
        $it = new CartesianProductIterator();
        $it->append($inner[] = new ArrayIterator(range(0, 2)));
        $it->append($inner[] = new ArrayIterator(range(3, 5)));

        $actual = $it->getArrayIterator();
        $this->assertInstanceOf('ArrayIterator', $actual);
        $this->assertCount(2, $actual);

        $this->assertSame($inner[0], $actual[0]);
        $this->assertSame($inner[1], $actual[1]);
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function invalidSortModeThrowsException()
    {
        new CartesianProductIterator(42);
    }

    /**
     * @test
     */
    public function finalNextDoesNotRewindAllIterators()
    {
        $iterator = new DebugCountingIteratorDecorator(new ArrayIterator([1]));
        $subject  = new CartesianProductIterator();
        $subject->append(new ArrayIterator([1, 2]));
        $subject->append($iterator);

        $this->assertEquals(2, iterator_count($subject));
        $this->assertEquals(2, $iterator->getRewindCount());
    }
}
