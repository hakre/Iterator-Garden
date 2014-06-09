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
     */
    protected function assertIteration(Traversable $expected, Traversable $actual)
    {
        $expected = $expected instanceof Iterator ? $expected : new IteratorIterator($expected);
        $actual   = $actual instanceof Iterator ? $actual : new IteratorIterator($actual);

        $both = new MultipleIterator(MultipleIterator::MIT_NEED_ALL);
        $both->attachIterator($expected);
        $both->attachIterator($actual);

        $index = -1;
        foreach ($both as $values) {
            $index++;
            $this->assertSame($values[0], $values[1], sprintf("Values of Iteration #%d", $index));
            $keys = $both->key();
            $this->assertSame($keys[0], $keys[1], sprintf("Keys of Iteration #%d", $index));
        }

        $this->assertFalse($expected->valid(), sprintf("Count mismatch: Expected Iterator still valid (#%d)", $index));
        $this->assertFalse($actual->valid(), sprintf("Count mismatch: Actual Iterator still valid (#%d)", $index));
    }

    protected function assertIterationValues(array $expected, Traversable $actual)
    {
        $actual = iterator_to_array($actual, FALSE);
        $this->assertEquals($expected, $actual);
    }
}
