<?php
/*
 * Iterator Garden - Let Iterators grow like flowers in the garden.
 * Copyright 2014, 2015 hakre <http://hakre.wordpress.com/>
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
 * Class DOMNodeIteratorTest
 *
 * @covers DOMNodeIterator
 */
class DOMNodeIteratorTest extends IteratorTestCase
{
    /**
     * @test
     */
    function creation()
    {
        $node    = new DOMNode;
        $subject = new DOMNodeIterator($node);
        $this->assertInstanceOf('DOMNodeIterator', $subject);
    }

    /**
     * @test
     */
    function traversal()
    {
        if (defined('HHVM_VERSION')) $this->markTestSkipped('skipped on HHVM');

        $doc = new DOMDocument();
        $doc->loadXML('<doc><parent><child>text</child></parent><parent><child>text</child></parent></doc>');
        $node    = $doc;
        $subject = new DOMNodeIterator($node);
        $this->assertFalse($subject->valid());
        $subject->rewind();
        $this->assertTrue($subject->valid());

        $this->assertInstanceOf('DOMDocument', $subject->current());
        $this->assertEquals(NULL, $subject->current()->ownerDocument);
        $this->assertEquals(0, $subject->key());

        $subject->next();
        $this->assertTrue($subject->valid());
        $this->assertInstanceOf('DOMElement', $subject->current());
        $this->assertTagName('doc', $subject->current());
        $this->assertEquals(1, $subject->key());
        $this->assertSame($doc, $subject->current()->parentNode);

        $subject->next();
        $subject->next();
        $subject->next();
        $this->assertTrue($subject->valid());
        $this->assertInstanceOf('DOMText', $subject->current());

        $subject->next();
        $this->assertTrue($subject->valid());
        $this->assertTagName('parent', $subject->current());

        $subject->next();
        $subject->next();
        $this->assertTrue($subject->valid());
        $this->assertInstanceOf('DOMText', $subject->current());

        // invalid iterator current() and key() should be NULL
        $subject->next();
        $this->assertIteratorInvalidation($subject);
    }

    /**
     * @param $tagName
     * @param $element
     */
    private function assertTagName($tagName, DOMNode $element)
    {
        if ($element instanceof DOMElement) {
            $this->assertEquals($tagName, $element->tagName);
        } else {
            $this->fail('Could not assert tag-name on a non-DOMElement DOMNode');
        }

    }
}
