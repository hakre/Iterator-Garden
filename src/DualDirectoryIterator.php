<?php
/**
 * IteratorGarden
 */

/**
 * Class DualDirectoryIterator
 *
 * Allows to iterate over two directories in parallel.
 */
class DualDirectoryIterator extends FilesystemIterator
{
    /**
     * @var FilesystemIterator
     */
    protected $pathA;

    /**
     * @var FilesystemIterator
     */
    protected $pathB;

    /**
     * @var int
     */
    protected $flags;

    /**
     * @var FilesystemIterator
     */
    protected $current;

    /**
     * @param string|FilesystemIterator $pathA
     * @param string|FilesystemIterator $pathB
     * @param int $flags
     */
    public function __construct($pathA, $pathB, $flags = NULL)
    {
        if ($flags === NULL) {
            $flags = self::KEY_AS_PATHNAME | self::CURRENT_AS_FILEINFO | self::SKIP_DOTS;
        }

        $this->flags = $flags;

        $this->pathA = $this->create($pathA, $flags);
        $this->pathB = $this->create($pathB, $flags);
    }

    /**
     * @param  string|FilesystemIterator $path
     * @param  int $flags
     * @return FilesystemIterator|FilesystemStubIterator
     */
    private function create($path, $flags)
    {
        if ($path instanceof FilesystemIterator) {
            $path->setFlags($flags);
            return $path;
        }

        if (!is_string($path)) {
            throw new InvalidArgumentException(
                sprintf('FilesystemIterator or string expected, %s given', gettype($path))
            );
        }

        if (is_dir($path)) {
            return new FilesystemIterator($path, $flags);
        }

        return new FilesystemStubIterator($path, $flags);
    }

    public function getFlags()
    {
        return $this->flags;
    }

    public function setFlags($flags = NULL)
    {

        parent::setFlags($flags);
    }


    public function rewind()
    {
        $this->pathA->rewind();
        $this->pathB->rewind();
        $this->current = $this->getFirstIterator();
    }

    public function valid()
    {
        return $this->pathA->valid() || $this->pathB->valid();
    }

    public function current()
    {
        $iter = $this->current;

        if (!$iter->valid()) {
            throw new LogicException('Invalid iterator given.');
        }
        return $iter->current();
    }

    public function key()
    {
        return $this->current->key();
    }

    public function next()
    {
        if ($this->areEqual()) {
            $this->pathA->next();
            $this->pathB->next();
        } else {
            $this->getFirstIterator()->next();
        }
        $this->current = $this->getFirstIterator();
    }

    /**
     * @return FilesystemIterator
     */
    protected function getFirstIterator()
    {
        if (!$this->pathA->valid()) {
            return $this->pathB;
        }

        if (!$this->pathB->valid()) {
            return $this->pathA;
        }

        $fileA = $this->pathA->getFilename();
        $fileB = $this->pathB->getFilename();

        if (strcasecmp($fileA, $fileB) < 0) {
            return $this->pathA;
        }
        return $this->pathB;
    }

    /**
     * @return bool
     */
    protected function areEqual()
    {
        if (!$this->pathA->valid() || !$this->pathB->valid()) {
            return FALSE;
        }

        $fileA = $this->pathA->getFilename();
        $fileB = $this->pathB->getFilename();
        return $fileA === $fileB;
    }
}

