<?php
/*
 * Iterator Garden
 */


/**
 * Class DebugIteratorEmitter
 */
class DebugIteratorEmitter
{
    const SIG_ANY = 1;

    private $handlers;

    private $debugIterator;

    public static function createFor(Iterator $iterator) {
        $emitter = new DebugIteratorEmitter();
        $emitter->debugIterator =  new DebugEmittingIterator($iterator, $emitter);
        return $emitter;
    }

    /**
     * @return NULL|DebugEmittingIterator
     */
    public function getDebugIterator() {
        return $this->debugIterator;
    }

    public function register($signal, $callback)
    {
        if (!is_int($signal)) {
            throw new InvalidArgumentException('$signal must be integer, %s given', gettype($signal));
        }

        $this->handlers[$signal][] = $callback;
    }

    /**
     * @param Traversable $subject
     * @param int $signal
     * @param string $name
     * @param mixed $parameter (optional)
     * @throws InvalidArgumentException
     */
    public function emit(Traversable $subject, $signal, $name, $parameter = NULL)
    {
        if (!is_int($signal)) {
            throw new InvalidArgumentException('$signal must be integer, %s given', gettype($signal));
        }

        if (!is_string($name)) {
            throw new InvalidArgumentException('$name must be string, %s given', gettype($name));
        }

        foreach ($this->handlers as $signalled => $callbacks) {
            if ($signal != $signalled & $signal) {
                continue;
            }
            foreach ($callbacks as $callback) {
                call_user_func_array($callback, array($subject, $signal, $name, $parameter));
            }
        }
    }

    public function registerOutput($callback = NULL)
    {
        if (NULL === $callback) {
            $callback = function($message) {
                echo $message;
            };
        }
        $this->register(
            DebugEmittingIterator::SIG_CALL_AFTER,
            function (Traversable $iterator, $signal, $name, $parameter) use (&$iteration, $callback) {

                $paramLabel = $parameter === NULL ? '' : ' ' . var_export($parameter, TRUE);

                $message = sprintf("#%s: %s()%s\n", var_export($iteration, true), $name, $paramLabel);
                call_user_func($callback, $message);

                switch ($name) {
                    case 'rewind':
                        $iteration = 0;
                        break;
                    case 'next' :
                        $iteration++;
                        break;
                }
            });

        return $this;
    }
}
