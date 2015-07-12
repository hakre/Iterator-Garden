<?php
/*
 * Iterator Garden - Let Iterators grow like flowers in the garden.
 * Copyright 2015 hakre <http://hakre.wordpress.com/>
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
 * @covers StaticIterator
 */
class StaticIteratorTest extends IteratorTestCase
{
    /**
     * @test
     */
    public function creation()
    {
        $iterator = new StaticIterator(new EmptyIterator());
        $this->assertInstanceOf('StaticIterator', $iterator);
    }

    /**
     * @test
     */
    public function staticNes()
    {
        $array    = new ArrayIterator(range(1, 3));
        $iterator = new IteratorIterator($array);
        $this->assertFalse($iterator->valid(), "precondition");

        $static = new StaticIterator($iterator);
        $this->assertFalse($static->valid(), "static is invalid");
        $static->rewind();
        $this->assertFalse($static->valid(), "static is invalid after rewind");
        $static->getInnerIterator()->rewind();
        $this->assertTrue($static->valid(), "static is valid after inner rewind");

        // test moving (and not moving) on:
        $this->assertSame(1, $static->current());
        $this->assertSame(0, $static->key());
        $static->next();
        $this->assertSame(1, $static->current());
        $static->getInnerIterator()->next();
        $this->assertSame(2, $static->current());
        $static->getInnerIterator()->next();
        $this->assertSame(3, $static->current());

        $static->getInnerIterator()->next();
        $this->assertFalse($static->valid());
        $this->assertSame(null, $static->current());
    }
}
