<?php
/*
 * Iterator Garden
 */

/**
 * Class DebugIterator
 */
class DebugIteratorIterator extends IteratorIterator implements DebugIteratorModes
{
    private $mode = self::MODE_ECHO;

    private $index;

    public function rewind()
    {
        $this->index = 0;
        $this->event(__FUNCTION__ . '()');
        parent::rewind();
        $this->event('after parent::' . __FUNCTION__ . '()');
    }

    public function valid()
    {
        $this->event(__FUNCTION__ . '()');
        $valid = parent::valid();
        $this->event(sprintf('parent::valid() is %s', $valid ? 'TRUE' : 'FALSE'));
        return $valid;
    }

    public function current()
    {
        $this->event(__FUNCTION__ . '()');
        $current = parent::current();
        $this->event(sprintf('parent::current() is %s', $this->varLabel($current)));
        return $current;
    }

    public function key()
    {
        $this->event(__FUNCTION__ . '()');
        $key = parent::key();
        $this->event(sprintf('parent::key() is %s', $this->varLabel($key)));
        return $key;
    }

    public function next()
    {
        $this->index++;
        $this->event(__FUNCTION__ . '()');
        parent::next();
        $this->event('after parent::' . __FUNCTION__ . '()');
    }

    public function debugGetIterationIndex() {
        return $this->index;
    }

    public function debugEvent($event) {
        $this->event($event);
    }

    /**
     * @param $var
     * @return string
     * @is-trait DebugIterator::varLabel
     */
    final protected function varLabel($var)
    {
        return DebugIterator::debugVarLabel($var);
    }

    /**
     * @param $event
     * @throws RuntimeException
     * @is-trait DebugIterator::event
     */
    final protected function event($event)
    {
        DebugIterator::debugEvent($this->getInnerIterator(), $this->index, $this->mode, $event);
    }

}
