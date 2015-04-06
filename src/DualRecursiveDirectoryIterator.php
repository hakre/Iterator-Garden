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

        $child->info_class = $this->info_class;

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
