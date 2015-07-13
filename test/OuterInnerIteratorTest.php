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
 * @covers OuterInnerIterator
 */
class OuterInnerIteratorTest extends IteratorTestCase
{
    /**
     * @test
     */
    function creation()
    {
        $outerOuter = new IteratorIterator(new IteratorIterator(new EmptyIterator()));
        $iterator   = new OuterInnerIterator($outerOuter);
        $this->assertInstanceOf('OuterInnerIterator', $iterator);
    }

    /**
     * @test
     *
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage OuterIterator of an OuterIterator required for outer-inner iteration, EmptyIterator
     *                           given
     */
    function creationWithInvalidItertor()
    {
        new OuterInnerIterator(new IteratorIterator(new EmptyIterator()));
    }

    /**
     * @test
     */
    function iteration()
    {
        $innerArray = new ArrayIterator(array(
            (object)array('foo' => 'baz-1', 'valid' => false),
            (object)array('foo' => 'bar-1', 'valid' => true),
            (object)array('foo' => 'bar-2', 'valid' => true),
            (object)array('foo' => 'baz-2', 'valid' => false),
            (object)array('foo' => 'baz-3', 'valid' => false),
        ));

        $outerFields = new FieldIterator($innerArray, 'foo');
        $filter      = new RegexIterator($outerFields, '~^bar-\d+$~i');

        $result = new OuterInnerIterator($filter);
        foreach ($result as $key => $value) {
            $this->assertInternalType('object', $value);
            $this->assertObjectHasAttribute('valid', $value);
            $this->assertTrue($value->valid);
            $this->assertObjectHasAttribute('foo', $value);
            $this->assertStringStartsWith('bar-', $value->foo);
            $this->addToAssertionCount(1);
            $this->assertInternalType('integer', $key);
        }
        $this->assertEquals(2, $this->getNumAssertions());
    }
}
