<?php
/*
 * Iterator Garden - Let Iterators grow like flowers in the garden.
 * Copyright 2013, 2015 hakre <http://hakre.wordpress.com/>
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
 * @covers DebugIterator
 */
class DebugIteratorTest extends IteratorTestCase
{
    /**
     * @test
     */
    public function creation()
    {
        $subject = new DebugIterator(new EmptyIterator());
        $this->assertInstanceOf('DebugIterator', $subject);
    }

    /**
     * @test
     */
    public function iterations()
    {
        $subject = new DebugIterator(new EmptyIterator());
        $this->assertCount(0, iterator_to_array($subject));

        $subject = new DebugIterator(new ArrayIterator(array(1)));
        $this->expectOutputString(
            'Iterating (EmptyIterator): #0 rewind' . "\n" . 'Iterating (EmptyIterator): #0 valid' . "\n" .

            'Iterating (ArrayIterator): #0 rewind' . "\n" . 'Iterating (ArrayIterator): #0 valid' . "\n" .
            'Iterating (ArrayIterator): #0 current' . "\n" .
            'Iterating (ArrayIterator): #0 key' . "\n" .
            'Iterating (ArrayIterator): #1 next' . "\n" .
            'Iterating (ArrayIterator): #1 valid' . "\n"
        );

        $this->assertCount(1, iterator_to_array($subject));
    }

    /**
     * @test
     */
    public function stdErrMode()
    {
        $subject = new DebugIterator(new EmptyIterator());
        $subject->setMode($subject::MODE_STDERR);
        $this->assertCount(0, iterator_to_array($subject));
        $this->expectOutputString('');
    }

    /**
     * @test
     *
     * @expectedException PHPUnit_Framework_Error_Notice
     * @expectedExceptionMessage Iterating (EmptyIterator): #0 rewind
     */
    public function noticeMode()
    {
        $subject = new DebugIterator(new EmptyIterator());
        $subject->setMode($subject::MODE_NOTICE);
        $this->assertEquals(0, @iterator_count($subject));
        iterator_count($subject);
    }

    /**
     * @test
     *
     * @expectedException RuntimeException
     * @expectedExceptionMessage Iterating (EmptyIterator): #0 rewind
     */
    public function exceptioneMode()
    {
        $subject = new DebugIterator(new EmptyIterator());
        $subject->setMode(42);
        iterator_count($subject);
    }
}
