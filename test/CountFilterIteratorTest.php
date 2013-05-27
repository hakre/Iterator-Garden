<?php
/**
 * Iterator Garden
 */

class CountFilterIteratorTest extends IteratorTestCase
{
    public function testIteratorion() {

        $array = array(
            array(1, 3, 4),
            array(1, 2),
        );

        $expected = array(array(1, 3, 4),);

        $this->assertIterationValues($expected, new CountFilterIterator($array, 3));
    }
}
