<?php
/**
 * Iterator Garden
 */

class ForeachIteratorTest extends ForeachIteratorBaseTest
{
    /**
     * @dataProvider provideForeachAbleSamples
     */
    public function testConstructor($foreachAble, $valid)
    {
        $this->helperTestConstructor('ForeachIterator', $foreachAble, $valid);
    }

    public function testStaticUnits()
    {
        $array    = array('foo' => 'bar');
        $expected = array_values($array);
        $this->assertIterationValues($expected, ForeachIterator::getIterator($array));
        $this->assertIterationValues($expected, ForeachIterator::getTraversable($array));
    }
}
