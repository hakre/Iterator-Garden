<?php
/**
 * Iterator Garden
 */

class FetchingIteratorTest extends IteratorTestCase
{

    public function testConstructor()
    {
        $callback = $this->createCallbackWithValues();
        $subject  = new FetchingIterator($callback);
        $this->assertInstanceOf('FetchingIterator', $subject);
    }

    private function createCallbackWithValues(array $values = array())
    {
        $creator = function () use ($values) {
            $stack = array_reverse($values);
            return function () use (&$stack) {
                return array_pop($stack);
            };
        };

        return $creator();
    }

    public function testIteration()
    {
        $values = array('a', 'b', 'c');


        $this->assertIterationValues(
            $values,
            new FetchingIterator($this->createCallbackWithValues($values))
        );

        $this->assertIterationValues(
            array('a'),
            new FetchingIterator($this->createCallbackWithValues($values), 'b')
        );

        $this->assertIteration(
            new ArrayIterator($values),
            new FetchingIterator($this->createCallbackWithValues($values))
        );
    }
}
