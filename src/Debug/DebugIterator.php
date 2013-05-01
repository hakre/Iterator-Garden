<?php
/**
 * Iterator Garden
 */

/**
 * Class DebugIterator
 */
class DebugIterator extends IteratorIterator
{
    const MODE_NOTICE = 1;
    const MODE_ECHO   = 2;
    const MODE_STDERR = 3;

    private $mode = self::MODE_ECHO;

    private $index;

    public function rewind()
    {
        $this->index = 0;
        $this->event(__FUNCTION__);
        parent::rewind();
    }

    public function valid()
    {
        $this->event(__FUNCTION__);
        return parent::valid();
    }

    public function current()
    {
        $this->event(__FUNCTION__);
        return parent::current();
    }

    public function key()
    {
        $this->event(__FUNCTION__);
        return parent::key();
    }

    public function next()
    {
        $this->index++;
        $this->event(__FUNCTION__);
        parent::next();
    }

    final protected function event($event)
    {
        $message = sprintf("Iterating (%s): #%d %s", get_class($this->getInnerIterator()), $this->index, $event);

        switch ($this->mode) {
            case self::MODE_NOTICE:
                trigger_error($message);
                break;
            case self::MODE_ECHO:
                echo $message, "\n";
                break;
            case self::MODE_STDERR:
                fputs(STDERR, $message . "\n");
                break;
            default:
                throw new RuntimeException($message);
        }
    }
}
