--TEST--
Check is_callable behavior
--FILE--
<?php
echo "-- array('string', 'string') --\n";
var_dump(is_callable(array('string', 'string')          , true, $name), $name);
echo "-- array(null) --\n";
var_dump(is_callable(array(null)                        , true, $name), $name);
echo "-- array('string') --\n";
var_dump(is_callable(array('string')                    , true, $name), $name);
echo "-- array(null, 'string') --\n";
var_dump(is_callable(array(null, 'string')              , true, $name), $name);
echo "-- array('string', 'string', null) --\n";
var_dump(is_callable(array('string', 'string', null)    , true, $name), $name);
echo "-- array('string', 'string', 'string') --\n";
var_dump(is_callable(array('string', 'string', 'string'), true, $name), $name);

?>
--EXPECT--
-- array('string', 'string') --
bool(true)
string(14) "string::string"
-- array(null) --
bool(false)
string(5) "Array"
-- array('string') --
bool(false)
string(5) "Array"
-- array(null, 'string') --
bool(false)
string(5) "Array"
-- array('string', 'string', null) --
bool(false)
string(5) "Array"
-- array('string', 'string', 'string') --
bool(false)
string(5) "Array"
