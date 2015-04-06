<?php
/*
 * Iterator Garden - Let Iterators grow like flowers in the garden.
 * Copyright 2013, 2014 hakre <http://hakre.wordpress.com/>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Class DualDirectoryIterator
 *
 * Iterate over two directories at once.
 *
 * This inherits comparison and ordering amongst the two directory listings: Current results are ordered by
 * filename, if both are equal, the first path (A) is preferred over the second (B) and returned.
 *
 * TODO When switching to a decorator (see TODO in @see FilesystemStubiterator, flag/info-class handling might differ,
 *      so far setFileClass()/openFile() is missing, too
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
     * @var string
     */
    protected $info_class = 'SplFileInfo';

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
     * @param  int $flags to be set on new inner iterator returned
     * @throws InvalidArgumentException
     * @return FilesystemIterator|FilesystemStubIterator
     */
    private function create($path, $flags)
    {
        if ($path instanceof FilesystemIterator) {
            $path->setFlags($flags);
            return $path;
        }

        if (!is_string($path)) {
            $message = sprintf('path should be string, %s given', gettype($path));
            trigger_error($message);
        }

        if ($path instanceof SplFileInfo) {
            $path = $path->getPathname();
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
        $this->flags = $flags;

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

        if (!($iter && $iter->valid())) {
            throw new LogicException(
                sprintf('Invalid Iterator given or %s in undefined state - perhaps rewind() first.', __CLASS__)
            );
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
     * @param int $position
     *
     * @throws BadMethodCallException
     */
    public function seek($position)
    {
        throw new BadMethodCallException('Not implemented.');
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

        $comparison = $this->compareBothFilename();

        if ($comparison <= 0) {
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

        $comparison = $this->compareBothFilename();

        return 0 === $comparison;
    }

    /**
     * strcmp on both A and B filenames
     *
     * @return int
     */
    private function compareBothFilename()
    {
        $fileA = $this->pathA->getFilename();
        $fileB = $this->pathB->getFilename();

        return strcmp($fileA, $fileB);
    }

    /**
     * @return string[] array of pathnames (of which not all may exist)
     */
    public function getPathnames()
    {
        $separator = $this->flags & self::UNIX_PATHS ? '/' : DIRECTORY_SEPARATOR;
        $fileName = $this->current->getFilename();

        return array(
            $this->pathA->getPath() . $separator . $fileName,
            $this->pathB->getPath() . $separator . $fileName,
        );
    }

    /**
     * Get an array of the current inner directories, which depending on the flags settings
     * can be concrete pathnames, filename or SplFileInfo objects (with the overloaded class)
     * then.
     *
     * This method is a bit fuzzy, for less differentiated results
     *
     * @see getPathnames()      - returning string[]
     * @see getFileInfos()      - returning SplFileInfo[]
     * @see getInnerIterators() - returning FilesystemIterator[]
     *
     * @return array|string[]|FilesystemIterator[]|SplFileInfo[]
     */
    public function getInnerDirectories()
    {
        $flags = $this->flags;

        // CURRENT_AS_SELF (16) is the default case, which means $this (the DualDirectoryIterator) but as
        //                      this is not current() inner paths are returned which are of self-like type
        if ($flags & self::CURRENT_AS_SELF) {
            return $this->getInnerIterators();
        }

        // CURRENT_AS_PATHNAME (32)
        if ($flags & self::CURRENT_AS_PATHNAME) {
            return $this->getPathnames();
        }

        // CURRENT_AS_FILEINFO (0)
        return $this->getFileInfos();
    }

    /**
     * @return FilesystemIterator[]
     */
    public function getInnerIterators() {
        return array(
            $this->pathA,
            $this->pathB,
        );
    }

    /**
     * Sets the class used with getFileInfo and getPathInfo
     *
     * @param string $class_name (optional) of an SplFileInfo derived class to use
     */
    public function setInfoClass($class_name = NULL)
    {
        if ($class_name === NULL) {
            $class_name = 'SplFileInfo';
        }

        foreach ($this->getInnerIterators() as $path) {
            $path->setInfoClass($class_name);
        }

        $this->info_class = $class_name;
    }

    /**
     * Gets an SplFileInfo object for the file
     *
     * @param string $class_name of an SplFileInfo derived class to use
     *
     * @return SplFileInfo object created for the file
     */
    public function getFileInfo($class_name = NULL)
    {
        if ($class_name === NULL) {
            $class_name = $this->info_class;
        }

        $current = $this->getFirstIterator();

        return $current->getFileInfo($class_name);
    }

    /**
     * @param string $class_name (optional) of an SplFileInfo derived class to use
     *
     * @return SplFileInfo[] array of SplFileInfo-s (of which may not all files exist)
     */
    public function getFileInfos($class_name = NULL)
    {
        if ($class_name === NULL) {
            $class_name = $this->info_class;
        }

        $paths = $this->getInnerIterators();

        $fileInfos = array();
        foreach ($paths as $path) {
            $fileInfos[] = $path->getFileInfo($class_name);
        }

        return $fileInfos;
    }

    /**
     * @param null $class_name
     *
     * @return SplFileInfo object for the parent path of the file
     */
    public function getPathInfo($class_name = NULL)
    {
        if ($class_name === NULL) {
            $class_name = $this->info_class;
        }

        $current = $this->getFirstIterator();

        return $current->getPathInfo($class_name);
    }
}
