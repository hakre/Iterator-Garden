<?php
/**
 * Iterator Garden
 */

/**
 * @covers DecoratingIterator
 */
class DecoratingIteratorTest extends IteratorTestCase
{

    public function testConstructor() {
        $it = new DecoratingIterator(new EmptyIterator(), 'is_null');
    }

    public function testCallbackDecorator() {
        $called = 0;
        $it = new DecoratingIterator(new ArrayIterator(array(1)), function($current) use (&$called) {
            $this->assertEquals(1, $current);
            $called++;
            return $current;
        });

        iterator_to_array($it);

        $this->assertSame(1, $called);
    }

    public function testCallbackClass() {

        $it = new DecoratingIterator(new ArrayIterator(array(new stdClass())), 'ForeachIterator');

        $array = iterator_to_array($it);

        $this->assertCount(1, $array);

        $this->assertInstanceOf('ForeachIterator', $array[0]);
    }

    /**
     * @test
     * @expectedException Exception
     */
    public function exceptionOnInvalidDecoratorArgument() {

        $it = new DecoratingIterator(new ArrayIterator(array(1)), '1invalid2classname');

        $array = iterator_to_array($it);
    }
}
