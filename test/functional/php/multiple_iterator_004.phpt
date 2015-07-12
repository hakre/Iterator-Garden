--TEST--
Iterator-Garden: MultipleIterator (attaching and detaching)
--FILE--
<?php
require __DIR__ . '/../../../vendor/autoload.php';

$mit = new MultipleIterator();
$empty = new EmptyIterator();

echo "-- One empty iterator attaching, info-setting and detaching --\n";
var_dump($mit->containsIterator($empty));
$mit->attachIterator($empty);
var_dump($mit->countIterators());
var_dump($mit->containsIterator($empty));
$mit->attachIterator($empty, null);
var_dump($mit->countIterators());
var_dump($mit->containsIterator($empty));
$mit->attachIterator($empty, "empty");
var_dump($mit->countIterators());
var_dump($mit->containsIterator($empty));
$mit->detachIterator($empty);
var_dump($mit->countIterators());
var_dump($mit->containsIterator($empty));
$mit->attachIterator($empty, "empty");
var_dump($mit->countIterators());
var_dump($mit->containsIterator($empty));

echo "-- Attach with invalid info (key) --\n";
try {
    $mit->attachIterator($empty, array());
} catch (Exception $e) {
    var_dump(get_class($e), $e->getMessage());
}
var_dump($mit->countIterators());
var_dump($mit->containsIterator($empty));

echo "-- Detach (and again) --\n";
$mit->detachIterator($empty);
var_dump($mit->countIterators());
var_dump($mit->containsIterator($empty));
$mit->detachIterator($empty);
var_dump($mit->countIterators());
var_dump($mit->containsIterator($empty));

echo "-- Attach with valid info (key) --\n";
$mit->attachIterator($empty, "empty");
var_dump($mit->countIterators());
var_dump($mit->containsIterator($empty));

echo "-- Attach same iterator with same info again --\n";
try {
    $mit->attachIterator($empty, "empty");
} catch (Exception $e) {
    var_dump(get_class($e));
    var_dump($e->getMessage());
}
var_dump($mit->countIterators());
var_dump($mit->containsIterator($empty));

?>
--EXPECT--
-- One empty iterator attaching, info-setting and detaching --
bool(false)
int(1)
bool(true)
int(1)
bool(true)
int(1)
bool(true)
int(0)
bool(false)
int(1)
bool(true)
-- Attach with invalid info (key) --
string(24) "InvalidArgumentException"
string(36) "Info must be NULL, integer or string"
int(1)
bool(true)
-- Detach (and again) --
int(0)
bool(false)
int(0)
bool(false)
-- Attach with valid info (key) --
int(1)
bool(true)
-- Attach same iterator with same info again --
string(24) "InvalidArgumentException"
string(21) "Key duplication error"
int(1)
bool(true)
