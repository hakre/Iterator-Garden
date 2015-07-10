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
 * @covers DecoratingIterator
 */
class DecoratingIteratorTest extends IteratorTestCase
{

    public function testConstructor() {
        $it = new DecoratingIterator(new EmptyIterator(), 'is_null');
    }

    public function testCallbackDecorator() {
        $assertions = $this;
        $it = new DecoratingIterator(new ArrayIterator(array(1)), function($current) use (&$called, $assertions) {
            $assertions->assertEquals(1, $current);
            $assertions->addToAssertionCount(1);
            return $current;
        });

        iterator_to_array($it);

        $this->assertSame(1, $this->getNumAssertions());
    }

    public function testCallbackClass() {

        $it = new DecoratingIterator(new ArrayIterator(array(new stdClass())), 'ForeachIterator');

        $array = iterator_to_array($it);

        $this->assertCount(1, $array);

        $this->assertInstanceOf('ForeachIterator', $array[0]);
    }

    /**
     * @test
     * @expectedException Exception
     */
    public function exceptionOnInvalidDecoratorArgument() {

        $it = new DecoratingIterator(new ArrayIterator(array(1)), '1invalid2classname');

        $array = iterator_to_array($it);
    }
}
