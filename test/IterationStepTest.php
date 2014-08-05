<?php
/*
 * Iterator Garden
 */

/**
 * @cover IterationStep
 */
class IterationStepTest extends IteratorTestCase
{
    /**
     * @test
     */
    public function createFromIterator()
    {
        $step = IterationStep::createFromIterator(new RangeIterator(1, 1));

        $this->assertTrue($step->getValid());

        $step = IterationStep::createFromIterator(new EmptyIterator());

        $this->assertFalse($step->getValid());
    }

    /**
     * @test
     */
    public function createFromArray()
    {
        $array = array('a', 'b');

        $step = IterationStep::createFromArray($array);
        $this->assertEquals('a', $step->getCurrent());
        $this->assertGreaterThan(-1, $step->getKey());
        $this->assertTrue($step->getValid());

        next($array);

        $step = IterationStep::createFromArray($array);
        $this->assertEquals('b', $step->getCurrent());
        $this->assertTrue($step->getValid());

        next($array);

        $step = IterationStep::createFromArray($array);
        $this->assertFalse($step->getValid());
        $this->assertNull($step->getKey());
    }

}
