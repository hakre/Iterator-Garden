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
 * Class IteratorTestCase
 */
abstract class IteratorTestCase extends PHPUnit_Framework_TestCase
{
    /**
     * Assert an Iterator is invalid and returns NULL for current() and key() as this is
     * standard behavior.
     *
     * @param Iterator $iterator
     */
    protected function assertIteratorInvalidation(Iterator $iterator)
    {
        $this->assertIteratorInvalid($iterator);
        // invalid iterator should be next()'ed as often as one wants to w/o changing valid()/current()/key() state
        // this assertion does it twice only which should at least catch one-off cases and a little more.
        $iterator->next();
        $this->assertIteratorInvalid($iterator);
        $iterator->next();
        $this->assertIteratorInvalid($iterator);
    }

    private function assertIteratorInvalid(Iterator $iterator)
    {
        $this->assertFalse($iterator->valid());
        $this->assertEquals(NULL, $iterator->current());
        $this->assertEquals(NULL, $iterator->key());
    }

    /**
     * Iteration test
     *
     * @param Traversable $expected
     * @param Traversable $actual
     * @param string      $message (optional)
     */
    protected function assertIteration(Traversable $expected, Traversable $actual, $message = '')
    {
        if ($message) {
            $message .= "\n";
        }

        $expected = $expected instanceof Iterator ? $expected : new IteratorIterator($expected);
        $actual   = $actual instanceof Iterator ? $actual : new IteratorIterator($actual);

        $both = new MultipleIterator(MultipleIterator::MIT_NEED_ALL);
        $both->attachIterator($expected);
        $both->attachIterator($actual);

        $index = -1;
        foreach ($both as $values) {
            $index++;
            $this->assertSame($values[0], $values[1], sprintf("%sValues of Iteration #%d", $message, $index));
            $keys = $both->key();
            $this->assertSame($keys[0], $keys[1], sprintf("%sKeys of Iteration #%d", $message, $index));
        }

        $this->assertFalse($expected->valid(), sprintf("%sCount mismatch: Expected Iterator still valid (#%d)", $message, $index));
        $this->assertFalse($actual->valid(), sprintf("%sCount mismatch: Actual Iterator still valid (#%d)", $message, $index));
    }

    protected function assertIterationValues(array $expected, Traversable $actual, $message = '')
    {
        $actual = iterator_to_array($actual, FALSE);
        $this->assertEquals($expected, $actual, $message);
    }

    protected function assertIterationKeys(array $expected, Traversable $actual, $message = '')
    {
        $subject = new DecoratingIteratorDecorator($actual, function ($current) use ($actual) {
            return $actual->key();
        });
        $this->assertIterationValues($expected, $subject, $message);
    }
}
