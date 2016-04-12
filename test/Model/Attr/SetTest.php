<?php

namespace Mismatch\Model\Attr;

class SetTest extends \PHPUnit_Framework_TestCase
{
    use PrimitiveTestCase;

    public function createSubject($metadata, $opts = [])
    {
        return new Set($metadata, $opts);
    }
}
