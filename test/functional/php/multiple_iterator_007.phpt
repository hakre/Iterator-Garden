--TEST--
Iterator-Garden: MultipleIterator (flags cloning and behavior)
--FILE--
<?php
require __DIR__ . '/../../../vendor/autoload.php';

$mit = new MultipleIterator();

echo "-- Flags cloning on empty MultipleIterator --\n";
var_dump($mit->getFlags());
$clone = clone $mit;
var_dump($clone->getFlags());
$new = new MultipleIterator(MultipleIterator::MIT_KEYS_ASSOC);
var_dump($new->getFlags());
$clone = clone $new;
var_dump($clone->getFlags());

echo "-- Flags cloning on non-empty MultipleIterator --\n";
$array = new ArrayIterator(array('Array'));
$mit->attachIterator($array, 'array-1');
var_dump($mit->getFlags());
$clone = clone $mit;
var_dump($clone->getFlags());
$new = new MultipleIterator(MultipleIterator::MIT_KEYS_ASSOC);
$new->attachIterator($array, 'array-1');
var_dump($new->getFlags());
var_dump($new->current());
$clone = clone $new;
var_dump($clone->getFlags());
var_dump($clone->current());


echo "-- Flags default behavior on non-empty MultipleIterator --\n";

$mit->setFlags(MultipleIterator::MIT_NEED_ANY | MultipleIterator::MIT_KEYS_ASSOC);
var_dump($mit->getFlags());
var_dump($mit->current());

$mit->setFlags(MultipleIterator::MIT_NEED_ALL | MultipleIterator::MIT_KEYS_ASSOC);
var_dump($mit->getFlags());
var_dump($mit->current());

$mit->setFlags(MultipleIterator::MIT_NEED_ALL | MultipleIterator::MIT_KEYS_ASSOC | MultipleIterator::MIT_KEYS_NUMERIC);
var_dump($mit->getFlags()); # same as above

$mit->setFlags(4);
var_dump($mit->getFlags());
var_dump($mit->current());

$mit->setFlags(5);
var_dump($mit->getFlags());
var_dump($mit->current());

$mit->setFlags(6);
var_dump($mit->getFlags());
var_dump($mit->current());

$mit->setFlags(255);
var_dump($mit->getFlags());
var_dump($mit->current());

$mit->setFlags(-1);
var_dump($mit->getFlags());
var_dump($mit->current());

$mit->setFlags(-2);
var_dump($mit->getFlags());
var_dump($mit->current());

$mit->setFlags(-3);
var_dump($mit->getFlags());
var_dump($mit->current());

$mit->setFlags(2147483647);
var_dump($mit->getFlags());
var_dump($mit->current());

?>
--EXPECT--
-- Flags cloning on empty MultipleIterator --
int(1)
int(0)
int(2)
int(0)
-- Flags cloning on non-empty MultipleIterator --
int(1)
int(0)
int(2)
array(1) {
  ["array-1"]=>
  string(5) "Array"
}
int(0)
array(1) {
  [0]=>
  string(5) "Array"
}
-- Flags default behavior on non-empty MultipleIterator --
int(2)
array(1) {
  ["array-1"]=>
  string(5) "Array"
}
int(3)
array(1) {
  ["array-1"]=>
  string(5) "Array"
}
int(3)
int(4)
array(1) {
  [0]=>
  string(5) "Array"
}
int(5)
array(1) {
  [0]=>
  string(5) "Array"
}
int(6)
array(1) {
  ["array-1"]=>
  string(5) "Array"
}
int(255)
array(1) {
  ["array-1"]=>
  string(5) "Array"
}
int(-1)
array(1) {
  ["array-1"]=>
  string(5) "Array"
}
int(-2)
array(1) {
  ["array-1"]=>
  string(5) "Array"
}
int(-3)
array(1) {
  [0]=>
  string(5) "Array"
}
int(2147483647)
array(1) {
  ["array-1"]=>
  string(5) "Array"
}
