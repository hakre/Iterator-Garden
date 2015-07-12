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
 * @covers IndexIteration
 */
class IndexIterationTest extends IteratorTestCase
{
    /**
     * @test
     */
    function index()
    {
        $array = new ArrayIterator(array(1, 2, 3));
        $this->assertEquals(3, iterator_count($array), 'precondition');

        $iterator = new IndexIteration($array);
        $this->assertNull($iterator->getIndex());
        $iterator->rewind();
        $this->assertEquals(0, $iterator->getIndex());

        $this->assertEquals(3, iterator_count($iterator), 'precondition');
        $this->assertEquals(3, $iterator->getIndex());
        $this->assertFalse($iterator->valid());
    }

    /**
     * @test
     *
     * In this iteration assertion, the inner iterator is next()'ed as well while the
     * outer iterator (IndexIterator) that decorates it is next()'ing it, too.
     */
    function stackedIteration()
    {
        $expected = new ArrayIterator(range(0, 2));
        $actual   = new IndexIteration($expected);

        $this->assertSame(null, $actual->getIndex());

        $this->assertIteration(new StaticIterator($expected), $actual);

        $this->assertSame(3, $actual->getIndex());
    }
}
