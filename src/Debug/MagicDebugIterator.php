<?php
/**
 * Iterator Garden
 */

/**
 * Class MagicDebugIterator
 *
 * A MagicDebugIterator that also shows access to unset properties (__get()) and method
 * calls to undefined methods (__call()).
 */
class MagicDebugIterator extends DebugIterator
{
    public function __get($name)
    {
        $this->event(sprintf('__get(%s)'), $name);
    }

    public function __call($name, $arguments)
    {
        $this->event(sprintf('__call(%s, [%s])'), $this->args($name), $this->args($arguments));
    }

    private function args($args)
    {
        if (is_array($args)) {
            return implode(', ', array_map(array($this, __FUNCTION__), $args));
        }

        return var_export($args, 1);
    }
}
