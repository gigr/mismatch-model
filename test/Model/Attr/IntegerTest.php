<?php

namespace Mismatch\Model\Attr;

class IntegerTest extends \PHPUnit_Framework_TestCase
{
    use PrimitiveTestCase;

    public function createSubject($metadata, $opts = [])
    {
        return new Integer($metadata, $opts);
    }
}
