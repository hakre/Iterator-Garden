<?php
/**
 * Iterator Garden
 */

class CountableForeachIteratorTest extends ForeachIteratorBaseTest
{
    public function provideCountableForeachAbleSamples()
    {
        return array(
            // array
            array(array(1, 2, 3), 3),
            // object
            array(new stdClass, 0),
            // Traversable
            array(simplexml_load_string('<r><e/><e/><e/><e/></r>'), 4),
            // Iterator
            array(new ArrayIterator(array(1, 2)), 2),
        );
    }

    /**
     * @dataProvider provideForeachAbleSamples
     */
    public function testConstructor($foreachAble, $valid)
    {
        $this->helperTestConstructor('CountableForeachIterator', $foreachAble, $valid);
    }

    /**
     * @dataProvider provideCountableForeachAbleSamples
     */
    public function testCount($foreachAble, $count)
    {
        $haystack = new CountableForeachIterator($foreachAble);
        $this->assertCount($count, $haystack);
    }
}
