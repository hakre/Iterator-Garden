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

class FetchingIteratorTest extends IteratorTestCase
{

    public function testConstructor()
    {
        $callback = $this->createCallbackWithValues();
        $subject  = new FetchingIterator($callback);
        $this->assertInstanceOf('FetchingIterator', $subject);
    }

    private function createCallbackWithValues(array $values = array())
    {
        $creator = function () use ($values) {
            $stack = array_reverse($values);
            return function () use (&$stack) {
                return array_pop($stack);
            };
        };

        return $creator();
    }

    public function testIteration()
    {
        $values = array('a', 'b', 'c');


        $this->assertIterationValues(
            $values,
            new FetchingIterator($this->createCallbackWithValues($values))
        );

        $this->assertIterationValues(
            array('a'),
            new FetchingIterator($this->createCallbackWithValues($values), 'b')
        );

        $this->assertIteration(
            new ArrayIterator($values),
            new FetchingIterator($this->createCallbackWithValues($values))
        );
    }
}
