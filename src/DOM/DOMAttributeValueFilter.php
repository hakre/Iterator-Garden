<?php
/*
 * Iterator-Garden
 */

/**
 * Class DOMAttributeValueFilter
 */
class DOMAttributeValueFilter extends FilterIterator
{
    private $attribute, $value;

    public function __construct(Iterator $iterator, $attribute, $value)
    {
        parent::__construct(new DOMAttributeFilter($iterator, $attribute));

        $this->attribute = $attribute;
        $this->value     = $value;
    }

    public function accept()
    {
        return $this->current()->getAttribute($this->attribute) === $this->value;
    }
}
