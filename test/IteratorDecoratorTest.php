<?php
/**
 * Iterator Garden
 */

class IteratorDecoratorTest extends IteratorTestCase
{
    function testIteration()
    {
        $expected  = new ArrayIterator(range(0, 2));
        $actual    = new IteratorDecorator($expected);

        $this->assertIteration($expected, $actual);
    }

    function testDecoration()
    {
        $subject  = new ArrayIterator(range(0, 2));
        $decorated = new IteratorDecorator($subject);

        $this->assertSame($subject->valid(), TRUE);

        $subject->next();
        $this->assertSame($decorated->current(), 1);

        $this->assertSame($subject, $decorated->getInnerIterator());
    }
}
