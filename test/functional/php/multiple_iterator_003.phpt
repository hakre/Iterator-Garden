--TEST--
Iterator-Garden: MultipleIterator (numeric key behavior)
--FILE--
<?php
require __DIR__ . '/../../../vendor/autoload.php';

$mit = new MultipleIterator(MultipleIterator::MIT_KEYS_NUMERIC);
var_dump($mit->getFlags());

$mit->rewind();
var_dump($mit->valid());
var_dump($mit->current());
var_dump($mit->key());

$empty = new EmptyIterator();
$mit->attachIterator($empty, 'empty');
$mit->rewind();
var_dump($mit->valid());
var_dump($mit->current());
var_dump($mit->key());

$array = new IteratorIterator(new ArrayIterator(range(1, 1)));
$mit->attachIterator($array, 'array');
$mit->rewind();
var_dump($mit->valid());
var_dump($mit->current());
var_dump($mit->key());

?>
--EXPECT--
int(0)
bool(false)
bool(false)
bool(false)
bool(false)
array(1) {
  [0]=>
  NULL
}
array(1) {
  [0]=>
  NULL
}
bool(true)
array(2) {
  [0]=>
  NULL
  [1]=>
  int(1)
}
array(2) {
  [0]=>
  NULL
  [1]=>
  int(0)
}
