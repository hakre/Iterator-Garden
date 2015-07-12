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
 * Class ConcreteMediatorTest
 *
 * @covers ConcreteMediator
 */
class ConcreteMediatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function creation()
    {
        $subject = new ConcreteMediator();
        $this->assertInstanceOf('ConcreteMediator', $subject);
    }

    /**
     * @test
     */
    public function notifications()
    {
        $mediator = new ConcreteMediator();

        $assertions = $this;
        $callback   = function (Mediator $eventTarget, $args) use ($mediator, $assertions) {
            $assertions->assertSame($mediator, $eventTarget);
            $assertions->addToAssertionCount(1);
        };

        $this->assertEquals(0, $this->getNumAssertions());

        // add it once, call it once
        $mediator->addListener('addListener', $callback);
        $mediator->notify('addListener');
        $this->assertEquals(1, $this->getNumAssertions());
        $this->assertSame('addlistener', $mediator->getType());

        // add ut a second time, call it two times then
        $mediator->addListener('addListener', $callback);;
        $mediator->notify('addListener');
        $this->assertEquals(3, $this->getNumAssertions());

        // notify an unregistered event
        $mediator->notify('nul-device');

        // add with different type again
        $mediator->addListener('closure', $callback);
        $mediator->notify('closure');
        $this->assertEquals(4, $this->getNumAssertions());

    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage event type can not be an array or object
     */
    public function arrayTypeName()
    {
        $mediator = new ConcreteMediator();
        $mediator->addListener(array('****'), 'var_dump');
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage invalid event type name '****'
     */
    public function invalidTypeName()
    {
        $mediator = new ConcreteMediator();
        $mediator->addListener('****', 'var_dump');
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage invalid callback syntax 'Array'
     */
    public function invalidCallbackSyntax()
    {
        $mediator = new ConcreteMediator();
        $mediator->addListener('type', array(null, 'foo_syntax'));
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage callback is not callable '::'
     */
    public function invalidCallback()
    {
        $mediator = new ConcreteMediator();
        $mediator->addListener('type', array('', ''));
        $mediator->notify('type');
    }

}
