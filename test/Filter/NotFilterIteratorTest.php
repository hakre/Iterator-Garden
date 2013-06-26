<?php
/**
 * Iterator Garden
 */

class NotFilterIteratorTest extends IteratorTestCase
{
    public function testConstructor()
    {
        $notFilter = $this->createNotFilter(range('a', 'c'), FALSE);

        $this->assertInstanceOf('NotFilterIterator', $notFilter);
    }

    public function testInnerIterator()
    {
        $values = range('a', 'c');

        $filter = $this->createNotFilter($values, FALSE);

        $this->assertIterationValues($values, $filter->getInnerIterator());
    }

    public function testInnerFilterIterator()
    {
        $values = range('a', 'c');

        $filterAll = $this->createNotFilter($values, TRUE);

        $this->assertIterationValues($values, $filterAll->getInnerFilterIterator());

        $filterNone = $this->createNotFilter($values, FALSE);

        $this->assertIterationValues(array(), $filterNone->getInnerFilterIterator());

    }

    public function testFilterInversion()
    {
        $values = range('a', 'c');

        $filterAll = $this->createNotFilter($values, TRUE);
        $this->assertIterationValues(array(), $filterAll, 'test invert accepting All');

        $filterNone = $this->createNotFilter($values, FALSE);
        $this->assertIterationValues($values, $filterNone, 'test invert filtering None');
    }

    private function createNotFilter(array $values, $acceptValueToInvert)
    {
        $callbackAcceptValue = (bool)$acceptValueToInvert;

        $callback = function ($current, $key, $iterator) use ($callbackAcceptValue) {
            printf("DEBUG: Accept %s\n", $callbackAcceptValue ? 'TRUE' : 'FALSE');
            return $callbackAcceptValue;
        };

        return $this->createValuesCallbackNotFilter($values, $callback);
    }

    private function createValuesCallbackFilter(array $values, callable $callback)
    {
        $iterator = new ArrayIterator($values);

        return new CallbackFilterIterator($iterator, $callback);
    }

    private function createValuesCallbackNotFilter(array $values, callable $callback)
    {
        return new NotFilterIterator($this->createValuesCallbackFilter($values, $callback));
    }
}
