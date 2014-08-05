<?php
/*
 * Iterator Garden
 */

/**
 * Class DOMXPathElementsIterator
 *
 * Iterates over the result of an XPath query being as if it were a list of DOMElements.
 *
 * Due to PHP memory leaks with DOMXPath, this iterator uses SimpleXMLElement::xpath()
 * internally and re-imports the result nodes into DOM. This effectively prevents
 * memory leaks.
 *
 * Note: Due to the conversion, the XPath expression will only return DOMElements.
 */
class DOMXPathElementsIterator implements IteratorAggregate
{
    private $node, $expression, $prefixes;

    private $lastDocument;

    public function __construct(DOMNode $node, $expression, array $prefixes = [])
    {
        $this->node       = $node;
        $this->expression = $expression;
        $this->prefixes   = $prefixes;
    }

    public function getIterator()
    {
        $node = simplexml_import_dom($this->node);

        foreach ($this->prefixes as $prefix => $namespaceUri) {
            $node->registerXPathNamespace($prefix, $namespaceUri);
        }

        $result = $node->xpath($this->expression);

        return new DecoratingIterator(
            new ArrayIterator($result),
            function (SimpleXMLElement $node) {
                return dom_import_simplexml($node);
            }
        );
    }
}
