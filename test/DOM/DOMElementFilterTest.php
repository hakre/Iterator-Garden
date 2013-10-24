<?php
/*
 * Iterator Garden - Let Iterators grow like flowers in the garden.
 * Copyright 2015 hakre <http://hakre.wordpress.com/>
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
 * Class DOMElementFilterTest
 *
 * @covers DOMElementFilter
 */
class DOMElementFilterTest extends IteratorTestCase
{
    /**
     * @var DOMDocument;
     */
    private $doc;

    protected function setUp()
    {
        $this->doc = $doc = new DOMDocument();
        $doc->loadXML('<doc><parent><child>text</child></parent><parent><child>text</child></parent></doc>');
    }


    /**
     * @test
     */
    function creation()
    {
        $subject = new DOMElementFilter($this->doc->childNodes);
        $this->assertInstanceOf('DOMElementFilter', $subject);
    }

    /**
     * @test
     */
    function traversal()
    {
        $iterator = new DOMNodeIterator($doc = $this->doc);

        $subject = new DOMElementFilter($iterator);

        $this->assertFalse($subject->valid());
        $subject->rewind();
        $this->assertTrue($subject->valid());

        $this->assertCurrentElement(1, 'doc', $subject);

        $subject->next();
        $this->assertTrue($subject->valid());
        $this->assertCurrentElement(2, 'parent', $subject);
        $this->assertSame($doc, $subject->current()->parentNode->parentNode);

        $subject->next();
        $subject->next();
        $subject->next();
        $this->assertTrue($subject->valid());
        $this->assertCurrentElement(6, 'child', $subject);

        // invalid iterator current() and key() should be NULL
        $subject->next();
        $this->assertIteratorInvalidation($subject);
    }

    private function assertCurrentElement($key, $name, Iterator $iterator)
    {
        /** @var DOMElement $element */
        $element = $iterator->current();
        $this->assertInstanceOf('DOMElement', $element);
        $this->assertSame($this->doc, $element->ownerDocument, 'Assert ownerDocument');
        $this->assertEquals($name, $element->tagName);
        $this->assertEquals($key, $iterator->key());
    }
}
