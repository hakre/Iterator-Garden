<?php
/**
 * Iterator Garden
 */

/**
 * Class RangeIterator
 *
 * The RangeIterator allows to iterate over a range of numbers, from low to high
 */
class RangeIterator implements Iterator
{
    private $offset, $index, $length, $step;

    public function __construct($low, $high, $step = NULL)
    {
        $low  = $this->inputArgumentNumeric('Low', $low);
        $high = $this->inputArgumentNumeric('High', $high);

        if ($step === NULL) {
            $step = 1;
        }
        if (!is_integer($step) and !is_float($step)) {
            throw new InvalidArgumentException(sprintf('Step must be integer or float, %s given', gettype($step)));
        }

        $this->offset = $low;

        $step         = abs($step);
        $this->length = floor(abs(($high - $low) / $step)) + 1;
        $this->step   = $low > $high ? -$step : $step;
    }

    public function rewind()
    {
        $this->index = 0;
    }

    public function valid()
    {
        return $this->index < $this->length;
    }

    public function current()
    {
        return $this->offset + $this->index * $this->step;
    }

    public function key()
    {
        return $this->index;
    }

    public function next()
    {
        $this->index < $this->length
        && $this->index++;
    }

    /**
     * @param int $position
     */
    public function seek($position)
    {
        $this->index = $position;
    }

    /**
     * @param $name
     * @param $value
     * @return float|int
     * @throws InvalidArgumentException
     */
    private function inputArgumentNumeric($name, $value)
    {
        if (!is_numeric($value)) {
            throw new InvalidArgumentException(sprintf("%s must be a number or a numeric string, %s given", $name, gettype($value)));
        }

        if (is_string($value)) {
            $int = (int)$value;
            return "$int" === $value ? (int)$value : (float)$value;
        }

        if (is_int($value)) {
            return $value;
        }

        return (float)$value;
    }
}
