<?php
/*
 * Iterator Garden
 */

/**
 * Class DisabledIterator
 *
 * An IteratorIterator that does not rewind() or next() the inner iterator.
 *
 * NOTE: Use this iterator with care, if used inside foreach with an iterator
 *       that is valid can easily create an endless loop.
 */
class DisabledIterator extends NoRewindIterator
{
    public function next()
    {
    }
}
