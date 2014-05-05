<?php
/**
 * Iterator Garden
 */

/**
 * Class TraversableDecoratorTest
 */
class TraversableDecoratorTest extends IteratorTestCase
{
    public function testDecoratorWithTraversal()
    {

        $xml = '<root><ele/><ele/><ele/></root>';

        $subject   = new SimpleXMLElement($xml);
        $decorated = new TraversableDecorator($subject);
        $array     = iterator_to_array($subject, FALSE);

        $this->assertIterationValues($array, $decorated);
    }

    public function testEmptyDecoration()
    {
        $decorated = new TraversableDecorator();
        $this->assertIterationValues(array(), $decorated);
    }
}
