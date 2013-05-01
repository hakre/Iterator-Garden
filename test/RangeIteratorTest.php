<?php
/**
 * Iterator Garden
 */

class RangeIteratorTest extends IteratorTestCase
{

    public function testRange()
    {
        $from = 0;
        $to   = 1;
        $step = -.1;

        $this->assertRangeIterator($from, $to, $step);
        $this->assertRangeIterator($to, $from, $step);
    }

    public function testRangeWithSingleElement()
    {
        $this->assertRangeIterator(1, 1);
        $this->assertRangeIterator(1, 1, 1);
    }

    private function assertRangeIterator($from, $to, $step = NULL)
    {
        $refl       = new ReflectionClass('RangeIterator');
        $iterator   = $refl->newInstanceArgs(array($from, $to, $step));
        $rangeArray = new ArrayIterator(range($from, $to, $step));

        $this->assertIteration($rangeArray, $iterator);
    }
}
