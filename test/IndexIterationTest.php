<?php
/**
 * Iterator Garden
 */

class IndexIterationTest extends IteratorTestCase
{
    function testIteration()
    {
        $expected  = new ArrayIterator(range(0, 2));
        $actual    = new IndexIteration($expected);

        $this->assertSame(NULL, $actual->getIndex());

        $this->assertIteration($expected, $actual);

        $this->assertSame(2, $actual->getIndex());
    }
}
