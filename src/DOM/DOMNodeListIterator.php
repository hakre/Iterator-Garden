<?php
/*
 * Iterator Garden
 */

/**
 * Class DOMNodeListIterator
 *
 * DOMDocuments self-updating DOMNodeLists - even Traversable - can not be iterated with
 * foreach in a stable manner.
 *
 * This DOMNodeListIterator iterator is able to do so for any kind of DOMNodeList
 *
 * Note: If used on a DOMNodeList returned by DOMDocument::getElementsByTagname() or
 *       DOMDocument::getElementsByTagnameNS(), the iteration can be quite slow.
 *
 */
class DOMNodeListIterator implements Iterator
{
    private $nodeList;

    private $index;

    private $current;

    public function __construct(DOMNodeList $nodeList)
    {
        $this->nodeList = $nodeList;
    }

    public function rewind()
    {
        $this->index   = 0;
        $this->current = NULL;
    }

    public function valid()
    {
        return $this->index < $this->nodeList->length;
    }

    public function current()
    {
        if ($this->current === NULL) {
            $this->current = $this->nodeList->item($this->index);
        }
        return $this->current;
    }

    public function key()
    {
        return $this->index;
    }

    public function next()
    {
        $this->index++;
        $this->current = NULL;
    }
}
