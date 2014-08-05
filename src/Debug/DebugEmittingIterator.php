<?php
/*
 * Iterator Garden
 */

/**
 * Class DebugIteratorEmitter
 */
class DebugEmittingIterator extends IteratorDecorator
{
    // 1 2 4 8
    const SIG_CALL_ANY    = 3; # 2
    const SIG_CALL_BEFORE = 7; # 4   3+4
    const SIG_CALL_AFTER  = 11; # 8  3+8

    /**
     * @var DebugIteratorEmitter
     */
    private $emitter;

    private $iterationIndex;

    public function __construct(Iterator $iterator, DebugIteratorEmitter $emitter) {

        parent::__construct($iterator);

        $this->emitter = $emitter;
    }

    /**
     * @return DebugIteratorEmitter
     */
    public function getEmitter() {
        return $this->emitter;
    }

    public function rewind()
    {
        $this->iterationIndex = 0;

        $this->emit(self::SIG_CALL_BEFORE, __FUNCTION__);
        parent::rewind();
        $this->emit(self::SIG_CALL_AFTER, __FUNCTION__);
    }

    public function valid()
    {
        $this->emit(self::SIG_CALL_BEFORE, __FUNCTION__);
        $valid = parent::valid();
        $this->emit(self::SIG_CALL_AFTER, __FUNCTION__, $valid);
        return $valid;
    }

    public function current()
    {
        $this->emit(self::SIG_CALL_BEFORE, __FUNCTION__);
        $current = parent::current();
        $this->emit(self::SIG_CALL_AFTER, __FUNCTION__, $current);
        return $current;
    }

    public function key()
    {
        $this->emit(self::SIG_CALL_BEFORE, __FUNCTION__);
        $key = parent::key();
        $this->emit(self::SIG_CALL_AFTER, __FUNCTION__, $key);
        return $key;
    }

    public function next()
    {
        $this->emit(self::SIG_CALL_BEFORE, __FUNCTION__);
        parent::next();
        $this->emit(self::SIG_CALL_AFTER, __FUNCTION__);

        $this->iterationIndex++;
    }

    private function emit($signal, $name, $parameter = NULL) {
        $this->emitter->emit($this, $signal, $name, $parameter);
    }
}
