--TEST--
DOM node traversal checks
--FILE--
<?php

function dom_node_next(DOMNode $node)
{
    if ($node->firstChild) {
        return $node->firstChild;
    }

    do {
        if ($node->nextSibling) {
            return $node->nextSibling;
        }
    } while ($node = $node->parentNode);

    return NULL;
}

$doc = new DOMDocument();
$doc->loadXML('<doc><parent><child>text</child></parent><parent><child>text</child></parent></doc>');
$node = $doc;
do {
  echo "-- next node --\n";
  var_dump(get_class($node), gettype($node->ownerDocument), $node->nodeName, $node->nodeValue);
} while ($node = dom_node_next($node));
?>
--EXPECT--
-- next node --
string(11) "DOMDocument"
string(4) "NULL"
string(9) "#document"
NULL
-- next node --
string(10) "DOMElement"
string(6) "object"
string(3) "doc"
string(8) "texttext"
-- next node --
string(10) "DOMElement"
string(6) "object"
string(6) "parent"
string(4) "text"
-- next node --
string(10) "DOMElement"
string(6) "object"
string(5) "child"
string(4) "text"
-- next node --
string(7) "DOMText"
string(6) "object"
string(5) "#text"
string(4) "text"
-- next node --
string(10) "DOMElement"
string(6) "object"
string(6) "parent"
string(4) "text"
-- next node --
string(10) "DOMElement"
string(6) "object"
string(5) "child"
string(4) "text"
-- next node --
string(7) "DOMText"
string(6) "object"
string(5) "#text"
string(4) "text"
