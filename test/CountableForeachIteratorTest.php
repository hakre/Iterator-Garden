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
 * @covers CountableForeachIterator
 */
class CountableForeachIteratorTest extends ForeachIteratorBaseTest
{
    public function provideCountableForeachAbleSamples()
    {
        return array(
            // array
            array(array(1, 2, 3), 3),
            // object
            array(new stdClass, 0),
            // Traversable
            array(simplexml_load_string('<r><e/><e/><e/><e/></r>'), 4),
            // Iterator
            array(new ArrayIterator(array(1, 2)), 2),
        );
    }

    /**
     * @dataProvider provideForeachAbleSamples
     */
    public function testConstructor($foreachAble, $valid)
    {
        $this->helperTestConstructor('CountableForeachIterator', $foreachAble, $valid);
    }

    /**
     * @dataProvider provideCountableForeachAbleSamples
     * @covers CountableForeachIterator::count()
     */
    public function testCount($foreachAble, $count)
    {
        $haystack = new CountableForeachIterator($foreachAble);
        $this->assertCount($count, $haystack);
    }
}
