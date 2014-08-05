<?php
/*
 * Iterator Garden
 */

/**
 * Class NotFilterIterator
 *
 * Inverse a FilterIterator, transparent to the original filter if it uses innerIterator(),
 * transparent ot consumer if it uses innerIterator() as well.
 *
 * To have this concept working, we can't just invert the inner-iterators accept() [as I first thought]. This
 * is not possible because the innert iterator will go on until accept is TRUE, therefore on FALSE will give
 * no chance to return TRUE, it will "next()" on.
 *
 * TODO before anything else in this file, write tests for the FullCachingIterator
 * TODO chew this
 *
 * So the inner Iterator of the FilterItertor to be decorated needs to be obtained and wrapped in such a way that
 * the wrapper is able to *track* those accepts. This is only possible by caching the delta until the next accept() TRUE
 * or end of inner iteration. Then, in retroperspective, the "false" can be turned into trues.
 *
 * On the other hand, if nothing was skipped (accept() TRUE), we can just continue. So it only works with caching and
 * then providing the result. This is somewhat cool because it's hard to implement and no-one so far has it :)
 *
 * => the last one is false, because it was true (this is not true, see below)
 * => if there is no last one, there was none, so nothing to do, just (false/valid() is false/empty)
 * => if there is a last one *but* the validty is false, then we know it spurred to the end. Probably luckily,
 *    our caching iterator has this final ending valid()=false returning token. yay!
 *
 * NOTE: Will not work if wrapped FilterIterator does not use innerIterator()
 *       (which should not be anyway, but some developers do not see this, therefore noted here)
 *
 * TODO: Explain in FAQ why this is the care, how to fix and probably outline motivations of developers to fail.
 */
class NotFilterIterator extends FilterIterator
{
    private $filterIterator;

    public function __construct(FilterIterator $filterIterator) {
        $this->filterIterator = $filterIterator;
        parent::__construct($filterIterator->getInnerIterator());
    }

    public function getInnerFilterIterator() {
        return $this->filterIterator;
    }

    public function getInnerIterator() {
        return $this->filterIterator->getInnerIterator();
    }

    public function accept() {
        $result =  $this->filterIterator->accept();
        echo 'in the accept(): ', var_dump($result);
        $this->store = !$result;
        echo '  now storing: ', var_dump($this->store);
        return !$result;
    }

    public function current()
    {
        echo 'in the current() the store is: ', var_dump($this->store);
        throw new Exception('Current called.');
    }
}
