<?php

namespace Mismatch\Model\Attr;

class FloatTest extends \PHPUnit_Framework_TestCase
{
    use PrimitiveTestCase;

    public function createSubject($metadata, $opts = [])
    {
        return new Float($metadata, $opts);
    }
}
