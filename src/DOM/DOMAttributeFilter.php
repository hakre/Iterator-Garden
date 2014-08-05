<?php
/*
 * Iterator-Garden
 */

/**
 * Class DOMAttributeFilter
 */
class DOMAttributeFilter extends FilterIterator
{
    private $attributeName;

    public function __construct(Iterator $iterator, $attributeName)
    {
        parent::__construct(new InstanceOfFilter($iterator, 'DOMElement'));

        $this->attributeName = $attributeName;
    }

    public function accept()
    {
        return $this->current()->hasAttribute($this->attributeName);
    }
}
