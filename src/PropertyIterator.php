<?php
/*
 * IteratorGarden
 */

/**
 * Class PropertyIterator
 *
 * User-defined properties to iterate over an object
 */
class PropertyIterator extends TraversableDecorator
{
    private $object;
    private $properties;

    public function __construct($object, array $properties)
    {
        $this->object     = $object;
        $this->properties = $properties;
        parent::__construct(new ArrayIterator($properties));
    }

    public function current()
    {
        $name = parent::current();
        return $this->object->$name;
    }

    public function key()
    {
        return parent::current();
    }
}
