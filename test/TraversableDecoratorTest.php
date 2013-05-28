<?php
/**
 * Iterator Garden
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
}
