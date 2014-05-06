<?php
/**
 * Iterator Garden
 */

/**
 * Class FilesystemStubIterator
 *
 * A FilesystemIterator of which the directory must not exists.
 */
class FilesystemStubIterator extends FilesystemIterator
{
    private $flags;

    private $path;

    private $fileInfo;

    public function __construct($path, $flags = NULL)
    {
        if ($flags === NULL) {
            $flags = self::KEY_AS_PATHNAME | self::CURRENT_AS_FILEINFO | self::SKIP_DOTS;
        }

        $this->path  = $path;
        $this->flags = $flags;
    }

    public function getExtension()
    {
        return pathinfo($this->path, PATHINFO_EXTENSION);
    }

    public function getFlags()
    {
        return $this->flags;
    }

    public function setFlags($flags = NULL)
    {
        $this->flags = $flags;
    }

    public function getFilename()
    {
        return basename($this->path);
    }

    public function getFileInfo($class_name = NULL)
    {
        if ($this->fileInfo) {
            return $this->fileInfo;
        }
        $info = new SplFileInfo($this->path);

        if ($class_name !== NULL) {
            $info = $info->getFileInfo($class_name);
        }

        return $this->fileInfo = $info;
    }

    public function getPath()
    {
        return dirname($this->path);
    }

    public function getPathname()
    {
        return $this->path;
    }

    public function getPerms()
    {
        return $this->getFileInfo()->getPerms();
    }

    public function getInode()
    {
        return $this->getFileInfo()->getInode();
    }

    public function getSize()
    {
        return $this->getFileInfo()->getSize();
    }

    public function getOwner()
    {
        return $this->getFileInfo()->getOwner();
    }

    public function getGroup()
    {
        return $this->getFileInfo()->getGroup();
    }

    public function getATime()
    {
        return $this->getFileInfo()->getATime();
    }

    public function getMTime()
    {
        return $this->getFileInfo()->getMTime();
    }

    public function getCTime()
    {
        return $this->getFileInfo()->getCTime();
    }

    public function getType()
    {
        return $this->getFileInfo()->getType();
    }

    public function isWritable()
    {
        return $this->getFileInfo()->isWritable();
    }

    public function isReadable()
    {
        return $this->getFileInfo()->isReadable();
    }

    public function isFile()
    {
        return $this->getFileInfo()->isFile();
    }

    public function isDir()
    {
        return $this->getFileInfo()->isDir();
    }

    public function isLink()
    {
        return $this->getFileInfo()->isLink();
    }

    public function getLinkTarget()
    {
        return $this->getFileInfo()->getLinkTarget();
    }

    public function getRealPath()
    {
        return $this->getFileInfo()->getRealPath();
    }

    public function isExecutable()
    {
        return $this->getFileInfo()->isExecutable();
    }

    public function __toString()
    {
        return (string) $this->path;
    }

    public function getBasename($suffix = NULL)
    {
        return $this->getFileInfo()->getBasename($suffix);
    }

    public function getPathInfo($class_name = NULL)
    {
        if ($class_name === NULL) {
            return $this->getFileInfo()->getPathInfo();
        }

        return $this->getFileInfo()->getPathInfo($class_name);
    }

    public function openFile($open_mode = 'r', $use_include_path = FALSE, $context = NULL)
    {
        if ($context === NULL) {
            return $this->getFileInfo()->openFile($open_mode, $use_include_path);
        }

        return $this->getFileInfo()->openFile($open_mode, $use_include_path, $context);
    }

    public function valid()
    {
        return FALSE;
    }
}
