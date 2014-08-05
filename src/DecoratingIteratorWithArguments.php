<?php
/*
 * Iterator Garden
 */

/**
 * Class DecoratingIteratorWithArguments
 *
 * @author Marcus Börger (2008); see DecoratingIterator
 * @author hakre (2013)
 */
class xxxDecoratingIteratorWithArguments extends IteratorIterator
{
    private $decorator;
    private $args;

    function __construct(Traversable $iterator, $decorator, array $args = array())
    {
        $this->decorator = $decorator;
        $this->args      = $args ? array_combine(range(1, count($args)), $args) : $args;
        parent::__construct($iterator);
    }

    function current()
    {
        $decorator = $this->decorator;
        if (is_callable($decorator)) {
            $args = array(parent::current()) + $this->args;
            return call_user_func_array($decorator, $args);
        } elseif (class_exists($decorator)) {
            if (!$this->args) {
                return new $decorator(parent::current());
            } else {
                $reflected = new ReflectionClass($decorator);
                return $reflected->newInstanceArgs(array(parent::current()) + $this->args);
            }
        } else {
            throw new Exception('Not a valid decorator: ' . var_export($decorator, TRUE));
        }
    }
}
