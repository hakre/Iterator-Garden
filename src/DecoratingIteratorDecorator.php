<?php
/*
 * Iterator Garden
 */

/**
 * Class DecoratingIteratorDecorator
 */
class DecoratingIteratorDecorator extends IteratorDecorator
{
    private $decorator;

    function __construct(Iterator $iterator, $decorator)
    {
        $this->decorator = $decorator;
        parent::__construct($iterator);
    }

    function current()
    {
        $decorator = $this->decorator;
        if (is_callable($decorator)) {
            return call_user_func($decorator, $this->traversable->current());
        } elseif (class_exists($decorator)) {
            return new $decorator($this->traversable->current());
        } else {
            throw new Exception('Not a valid decorator: ' . var_export($decorator, TRUE));
        }
    }
}
