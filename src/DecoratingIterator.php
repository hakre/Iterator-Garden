<?php
/**
 * Iterator Garden
 */

/**
 * Class DecoratingIterator
 *
 * @author Marcus Börger (2008)
 * @link https://code.google.com/p/cvphplib/source/browse/trunk/cvphplib/code/iterator_madness.inc.php?r=6
 * @example http://stackoverflow.com/a/16998550/367456
 */
class DecoratingIterator extends IteratorIterator
{
    private $decorator;

    function __construct(Traversable $iterator, $decorator)
    {
        $this->decorator = $decorator;
        parent::__construct($iterator);
    }

    function current()
    {
        if (is_callable($this->decorator)) {
            return call_user_func($this->decorator, parent::current());
        } elseif (class_exists($this->decorator)) {
            return new $this->decorator(parent::current());
        } else {
            throw new Exception('Not a valid decorator: ' . var_export($this->decorator, TRUE));
        }
    }
}
