<?php
/*
 * Iterator Garden
 */

class NumericKeyIteratorTest extends IteratorTestCase
{
    public function testIteration() {
        $aToZ     = range('a', 'z');
        $expected = new ArrayIterator($aToZ);

        $subject  = new ArrayIterator(array_combine($aToZ, $aToZ));
        $actual   = new NumericKeyIterator($subject);

        $this->assertIteration($expected, $actual);
    }
}
