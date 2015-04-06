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
 * Class IteratorMediatorTest
 *
 * @covers IteratorMediator
 */
class IteratorMediatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function creation()
    {
        $mediator = new IteratorMediator();
        $this->assertInstanceOf('IteratorMediator', $mediator);
    }


    /**
     * @test
     */
    public function iteration()
    {
        $range    = new RangeIterator(1, 3);
        $iterator = new IteratorMediator($range);

        $assertListener = function (Mediator $mediator, $type, $extra = NULL) {
            $mediator->addListener($type, function ($eventTarget, $args) use (&$extraCall, $mediator) {
                if ($extraCall) {
                    return $extraCall($eventTarget, $args);
                }
                $this->addToAssertionCount(1);
                $this->assertInstanceOf('Mediator', $eventTarget);
                $this->assertInternalType('array', $args);
                $this->assertNotSame($eventTarget, $mediator);
                $this->assertNotEquals($eventTarget, $mediator);
            });
            $numAssertions = $this->getNumAssertions();
            $mediator->notify($type);
            $this->assertGreaterThan($numAssertions, $this->getNumAssertions());

            $extraCall = $extra;
        };

        $collect = function (ConcreteMediator $target, $args) use (&$collection) {
            $collection[] = array($target->getType(), $args ? $args[0] : NULL);
        };

        $events = array('rewind', 'valid', 'current', 'key', 'next');
        foreach ($events as $event) {
            $assertListener($iterator, $event, $collect);
        }

        $consume = iterator_to_array($iterator);
        $this->assertSame(array(1, 2, 3), $consume);

        $expect = array(
            array('rewind', NULL),
            array('valid', TRUE),
            array('current', 1),
            array('key', 0),
            array('next', NULL),
            array('valid', TRUE),
            array('current', 2),
            array('key', 1),
            array('next', NULL),
            array('valid', TRUE),
            array('current', 3),
            array('key', 2),
            array('next', NULL),
            array('valid', FALSE),
        );
        $this->assertEquals($expect, $collection);
    }
}
