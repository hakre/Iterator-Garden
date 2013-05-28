<?php
/**
 * Iterator Garden
 */

/**
 * Class IterationStep
 *
 * Represents a single iteration in an iteration.
 */
class IterationStep
{
    private $current, $key, $valid;

    public function __construct($valid, $current, $key)
    {
        $this->valid   = $valid;
        $this->current = $current;
        $this->key     = $key;
    }

    public static function createFromIterator(Iterator $iterator)
    {
        $valid = NULL;

        try {
            $valid = $iterator->valid();
        } catch (Exception $e) {
        }

        if (!$valid) {
            return new self($valid, NULL, NULL);
        }

        return new self(
            $valid,
            $iterator->current(),
            $iterator->key()
        );
    }

    public function getCurrent()
    {
        return $this->current;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getValid()
    {
        return $this->valid;
    }
}
