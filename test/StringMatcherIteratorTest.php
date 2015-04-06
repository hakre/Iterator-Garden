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
 * @covers StringMatcherIterator
 */
class StringMatcherIteratorTest extends IteratorTestCase
{
    /**
     * @test
     */
    public function creation()
    {
        $matcher = $this->getMock('StringMatcher');
        $subject = new StringMatcherIterator($matcher, "TEST");
        $this->assertInstanceOf('StringMatcherIterator', $subject);
    }

    /**
     * @test
     */
    public function iteration()
    {
        $matcher = new PregStringMatcher("~\\S+~");

        $subject = 'this is for real !';
        $results = array_combine(array(0, 5, 8, 12, 17), explode(' ', $subject));


        $iterator = new StringMatcherIterator($matcher, $subject);
        $this->assertEquals($results, iterator_to_array($iterator));
    }

    /**
     * @test
     */
    public function zeroLengthException()
    {
        $matcher = new PregStringMatcher("~(?<=i)~");

        $subject  = 'this is for real !';
        $iterator = new StringMatcherIterator($matcher, $subject);

        $iterator->rewind();
        $this->assertTrue($iterator->valid(), 'rewind');
        $this->assertEquals('', $iterator->current());

        try {
            $iterator->next();
            $this->fail('An expected exception has not been thrown');
        } catch (RuntimeException $e) {
            $this->addToAssertionCount(1);
            $this->assertEquals('Zero-length match at same offset', $e->getMessage());
        }
    }
}
