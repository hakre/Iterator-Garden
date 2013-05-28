<?php
/**
 * Iterator Garden
 */

abstract class ForeachIteratorBaseTest extends IteratorTestCase
{
    public function provideForeachAbleSamples()
    {
        return array(
            // NULL
            array(NULL, FALSE),
            // array
            array(array(), TRUE),
            // object
            array(new stdClass, TRUE),
            // Traversable
            array(simplexml_load_string('<r><e/><e/><e/><e/></r>'), TRUE),
            // Iterator
            array(new ArrayIterator(array()), TRUE),
        );
    }

    protected function helperTestConstructor($classname, $foreachAble, $valid)
    {
        try {
            $subject = new $classname($foreachAble);
        } catch (Exception $e) {
            $this->addToAssertionCount(1);
            if ($valid) {
                throw $e;
            }
            return;
        }
        $this->assertInstanceOf($classname, $subject);
    }
}


