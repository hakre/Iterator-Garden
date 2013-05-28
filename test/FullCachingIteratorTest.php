<?php
/**
 * Iterator Garden
 */

class FullCachingIteratorTest extends IteratorTestCase
{
    function testIteration()
    {
        $expected  = new ArrayIterator(range(0, 2));
        $actual    = new FullCachingIterator($expected);

        $this->assertIteration($expected, $actual);
    }
}
