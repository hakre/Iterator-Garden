<?php
/*
 * Iterator Garden - Let Iterators grow like flowers in the garden.
 * Copyright 2013, 2014 hakre <http://hakre.wordpress.com/>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Class DebugIterator
 */
class DebugIterator extends IteratorDecorator implements Iterator, DebugIteratorModes
{
    private $mode = self::MODE_ECHO;
    private $label;

    private $index;

    public function __construct(Iterator $iterator, $label = NULL) {
        $this->label = $label;
        parent::__construct($iterator);
    }

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
        $this->event(sprintf('parent::current() is %s', DebugIterator::debugVarLabel($current)));
        return $current;
    }

    public function key()
    {
        $this->event(__FUNCTION__ . '()');
        $key = parent::key();
        $this->event(sprintf('parent::key() is %s', DebugIterator::debugVarLabel($key)));
        return $key;
    }

    public function next()
    {
        $this->index++;
        $this->event(__FUNCTION__ . '()');
        parent::next();
        $this->event('after parent::' . __FUNCTION__ . '()');
    }

    /**
     * @param $event
     * @throws RuntimeException
     * @is-trait DebugIterator::event
     */
    final protected function event($event)
    {
        self::debugEvent($this, $this->index, $this->mode, $event);
    }

    /**
     * @param $var
     * @return string
     */
    final static function debugVarLabel($var)
    {
        return is_scalar($var) ? var_export($var, TRUE) : gettype($var);
    }

    final static function debugEvent(DebugIterator $debug, $index, $mode, $event)
    {
        if ($label = $debug->label) {
            $label .= " ";
        } else {
            $label = 'unnamed ';
        }

        $iterator = $debug->traversable;

        $message = sprintf("Iterating %s(%s): #%d %s", $label, get_class($iterator), $index, $event);

        switch ($mode) {
            case DebugIteratorModes::MODE_NOTICE:
                trigger_error($message);
                break;
            case DebugIteratorModes::MODE_ECHO:
                echo $message, "\n";
                break;
            case DebugIteratorModes::MODE_STDERR:
                fputs(STDERR, $message . "\n");
                break;
            default:
                throw new RuntimeException($message);
        }
    }
}

