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
 * @covers PregStringMatcher
 */
class PregStringMatcherTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function creation()
    {
        $subject = new PregStringMatcher("~~");
        $this->assertInstanceOf('PregStringMatcher', $subject);
    }

    /**
     * @test
     * @expectedException PHPUnit_Framework_Error_Warning
     * @expectedExceptionMessage Empty regular expression
     */
    public function exceptionInvalidPattern()
    {
        new PregStringMatcher("");
    }

    /**
     * @test
     */
    public function matching()
    {

        $matcher = new PregStringMatcher("~\\w~");
        $subject = 'ABCD';
        $results = str_split($subject);
        foreach ($results as $offset => $result) {
            $this->assertEquals($result, $matcher->match($subject, $offset));
        }
        $this->assertTrue(isset($offset));
        $this->assertNull($matcher->match($subject, 4));
    }

    /**
     * @test
     */
    public function iteration()
    {
        $matcher = new PregStringMatcher("~\\S+~");

        $subject = 'this is for real !';
        $results = explode(' ', $subject);

        $iterator = new FetchingIterator(function () use ($matcher, $subject) {
            static $offset = 0;
            $result = $matcher->match($subject, $offset);
            $offset = $matcher->getOffset() + strlen($result);
            return $result;
        });

        $this->assertEquals($results, iterator_to_array($iterator));
    }
}
