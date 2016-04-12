<?php

namespace Mismatch\Model\Attr;

class StringTest extends \PHPUnit_Framework_TestCase
{
    use PrimitiveTestCase;

    public function createSubject($metadata, $opts = [])
    {
        return new String($metadata, $opts);
    }
}
