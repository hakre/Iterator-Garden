<?php
/*
 * Iterator Garden
 */

class ExpandingIteratorTest extends IteratorTestCase
{
    public function testConstructor()
    {
        $expanding = new ExpandingIterator($this->getIteratorOfIterators());

        $this->assertInstanceOf('ExpandingIterator', $expanding);
    }

    public function testException()
    {
        $withExceptions = $this->getIteratorOfIteratorsAndStrings();

        $expanding = new ExpandingIterator($withExceptions);
        $thrown    = FALSE;
        try {
            $this->addToAssertionCount(1);
            $count = iterator_count($expanding);
        } catch (Exception $e) {
            $thrown = TRUE;
        }
        $this->assertTrue($thrown, 'Exception was thrown');

        $expanding = new ExpandingIterator($withExceptions, ExpandingIterator::CATCH_GET_CHILD);
        $count     = iterator_count($expanding);
        $this->assertSame(9, $count);
    }

    public function testIterationValues()
    {
        $values = [1, 2, 3, 'a', 'b', 'c', 4, 5, 6, 'd', 'e', 'f'];

        $expanding = new ExpandingIterator($this->getIteratorOfIterators());

        $this->assertIterationValues($values, $expanding);
    }

    private function getIteratorOfIteratorsAndStrings()
    {
        $array = [
            new ArrayIterator(range(1, 3)),
            'exception',
            new ArrayIterator(range(4, 6)),
            'exception',
            'exception',
            new ArrayIterator(range(7, 9)),
        ];
        return new ArrayIterator($array);
    }

    private function getIteratorOfIterators()
    {
        $array = [
            [1, 3],
            ['a', 'c'],
            [4, 6],
            ['d', 'f'],
        ];
        $it    = new ArrayIterator($array);
        return new DecoratingIterator($it, function (array $array) {
            list($from, $to) = $array;
            return new ArrayIterator(range($from, $to));
        });
    }
}
