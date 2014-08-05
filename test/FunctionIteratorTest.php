<?php
/*
 * Iterator Garden
 */

class FunctionIteratorTest extends IteratorTestCase
{
    public function testConstructor()
    {
        $function = function () {
            return FALSE;
        };
        $iter     = new FunctionIterator($function);
        $this->assertInstanceOf('FunctionIterator', $iter);
    }

    public function testIteration()
    {
        $array = ['danger!', 'hello', 'world'];
        $init  = function ($array) {
            return function () use (&$array) {
                return array_shift($array);
            };
        };
        $iter  = new FunctionIterator($init($array));
        $this->assertIterationValues($array, $iter);

        // test norewind on invalidated iteration
        $expected = $iter->key();
        $iter->rewind();
        $this->assertFalse($iter->valid());
        $iter->next();
        $this->assertSame($expected, $iter->key());
    }
}
