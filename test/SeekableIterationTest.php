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
 * Class SeekableIterationTest
 *
 * @covers SeekableIteration
 */
class SeekableIterationTest extends IteratorTestCase
{
    /**
     * @test
     */
    public function creation()
    {
        $seekable = new SeekableIteration(new EmptyIterator());
        $this->assertInstanceOf('SeekableIteration', $seekable);
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage SeekableIteration is forward only but seek-position 2 is lower than offset 3.
     */
    public function iteration()
    {
        $seekable = new SeekableIteration(new ArrayIterator(range(1, 4)));

        $this->assertNull($seekable->getIndex(), 'precondition');
        $this->assertFalse($seekable->valid(), 'precondition');

        $seekable->rewind();
        $this->assertTrue($seekable->valid());

        $seekable->seek(3);
        $this->assertTrue($seekable->valid());
        $this->assertEquals(4, $seekable->current());

        $seekable->seek(3, true);
        foreach ($seekable as $value) {
            $this->addToAssertionCount(1);
            $this->assertEquals(4, $value);
            break;
        }
        $this->assertEquals(1, $this->getNumAssertions());

        $seekable->seek(2);
    }

    /**
     * @test seeking has to rewind if the iterator has not yet been rewound
     */
    public function seekRewind()
    {
        $seekable = new SeekableIteration(new ArrayIterator(range(1, 4)));

        $this->assertNull($seekable->getIndex(), 'precondition');
        $this->assertFalse($seekable->valid(), 'precondition');

        $seekable->seek(0);
        $this->assertTrue($seekable->valid());
        $this->assertSame(0, $seekable->getIndex());
    }

    /**
     * @test
     */
    public function seekStart()
    {
        $seekable = new SeekableIteration(new ArrayIterator(range(1, 4)));

        $this->assertFalse($seekable->valid(), 'precondition');
        $this->assertNull($seekable->getIndex(), 'precondition');

        $seekable->seekStart(3);
        $this->assertNull($seekable->getIndex());
        $this->assertFalse($seekable->valid());

        foreach ($seekable as $value) {
            $this->assertSame(4, $value);
            $this->addToAssertionCount(1);
        }
        $this->assertEquals(1, $this->getNumAssertions());
    }
}
