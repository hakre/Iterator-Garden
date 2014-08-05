<?php
/*
 * Iterator Garden
 */

/**
 * Class CallbackFilterIterator
 *
 * Autoload Seam for PHP < 5.4
 */
class CallbackFilterIterator extends FilterIterator
{
    private $callback;

    public function __construct(Iterator $iterator, $callback)
    {
        $this->validateCallback($callback);
        $this->callback = $callback;
        parent::__construct($iterator);
    }

    private function validateCallback($callback)
    {
        if (is_callable($callback, FALSE, $name)) {
            return;
        }

        $message = sprintf(
            'CallbackFilterIterator::__construct() expects parameter 2 to be a valid callback, callback %s (%s) not found or invalid callback'
            , var_export($callback, TRUE)
            , var_export($name, TRUE)
        );

        throw new InvalidArgumentException($message);
    }

    public function accept()
    {
        return call_user_func(
            $this->callback,
            $this->current(),
            $this->key(),
            $this->getInnerIterator()
        );
    }
}
