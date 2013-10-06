<?php
/**
 * Iterator Garden
 */

/**
 * Class RecursiveDecoratingIterator
 */
class RecursiveDecoratingIterator extends DecoratingIterator implements RecursiveIterator
{
    private $decorator;

    const DECORATE_NONE     = 0;
    const DECORATE_LEAFS    = 1;
    const DECORATE_CHILDREN = 2;
    const DECORATE_NODES    = 3;

    private $mode;

    function __construct(Traversable $iterator, $decorator, $mode = self::DECORATE_LEAFS)
    {
        parent::__construct($iterator, $decorator);

        $this->decorator = $decorator;

        $this->mode = $mode === NULL ? self::DECORATE_LEAFS : $mode;
    }

    public function current()
    {
        $mode = $this->mode;
        $leaf = !$this->hasChildren();
        if (
            ($leaf and ($mode & self::DECORATE_LEAFS))
            or (!$leaf and $mode & self::DECORATE_CHILDREN)
        ) {
            return parent::current();
        }

        return $this->getInnerIterator()->current();
    }

    public function hasChildren()
    {
        return $this->getInnerIterator()->hasChildren();
    }

    public function getChildren()
    {
        return new self($this->getInnerIterator()->getChildren(), $this->decorator, $this->mode);
    }
}
