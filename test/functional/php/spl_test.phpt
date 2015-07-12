--TEST--
--FILE--
<?php
$refl = new ReflectionClass('OuterIterator');
echo $refl;
?>
--EXPECT--
Interface [ <internal:SPL> interface OuterIterator extends Iterator, Traversable ] {

  - Constants [0] {
  }

  - Static properties [0] {
  }

  - Static methods [0] {
  }

  - Properties [0] {
  }

  - Methods [6] {
    Method [ <internal:SPL> abstract public method getInnerIterator ] {

      - Parameters [0] {
      }
    }

    Method [ <internal:Core, inherits Iterator> abstract public method current ] {
    }

    Method [ <internal:Core, inherits Iterator> abstract public method next ] {
    }

    Method [ <internal:Core, inherits Iterator> abstract public method key ] {
    }

    Method [ <internal:Core, inherits Iterator> abstract public method valid ] {
    }

    Method [ <internal:Core, inherits Iterator> abstract public method rewind ] {
    }
  }
}
