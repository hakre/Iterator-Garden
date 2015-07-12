--TEST--
Iterator-Garden: MultipleIterator (assoc key behavior)
--FILE--
<?php
require __DIR__ . '/../../../vendor/autoload.php';

$mit = new MultipleIterator(MultipleIterator::MIT_KEYS_ASSOC);
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
int(2)
bool(false)
bool(false)
bool(false)
bool(false)
array(1) {
  ["empty"]=>
  NULL
}
array(1) {
  ["empty"]=>
  NULL
}
bool(true)
array(2) {
  ["empty"]=>
  NULL
  ["array"]=>
  int(1)
}
array(2) {
  ["empty"]=>
  NULL
  ["array"]=>
  int(0)
}
