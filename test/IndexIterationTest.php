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
 * @covers IndexIteration
 */
class IndexIterationTest extends IteratorTestCase
{
    function testIteration()
    {
        $expected  = new ArrayIterator(range(0, 2));
        $actual    = new IndexIteration($expected);

        $this->assertSame(NULL, $actual->getIndex());

        $this->assertIteration($expected, $actual);

        $this->assertSame(2, $actual->getIndex());
    }
}
