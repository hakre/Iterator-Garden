<?php
/**
 * Iterator Garden
 */

abstract class IteratorTestCase extends PHPUnit_Framework_TestCase
{
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
}
