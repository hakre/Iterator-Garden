<?php
/**
 * IteratorGarden
 */

/**
 * Class DualRecursiveDirectoryIterator
 */
class DualRecursiveDirectoryIterator extends DualDirectoryIterator implements RecursiveIterator
{
    protected $subPath;

    public function hasChildren()
    {
        if ($this->areEqual()) {
            return $this->pathA->isDir() || $this->pathB->isDir();
        }

        return $this->getFirstIterator()->isDir();
    }

    /**
     * @return RecursiveIterator An iterator for the current entry.
     */
    public function getChildren()
    {
        $fileName = $this->current->getFilename();

        $child = new DualRecursiveDirectoryIterator(
            $this->pathA->getPath() . '/' . $fileName,
            $this->pathB->getPath() . '/' . $fileName,
            $this->flags
        );

        $subPath = $this->subPath;

        $child->subPath = strlen($subPath)
            ? $subPath . '/' . $fileName
            : $fileName;
        ;

        return $child;
    }

    public function getSubPath()
    {
        return $this->subPath;
    }

    public function getSubPathname()
    {
        $fileName = $this->current->getFilename();
        $subPath  = $this->subPath;

        return strlen($subPath)
            ? $subPath . '/' . $fileName
            : $fileName
        ;
    }
}
