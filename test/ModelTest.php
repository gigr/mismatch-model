<?php

namespace Mismatch;

use Mismatch\Model\Metadata;

class ModelTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->metadata = new Metadata('Mismatch\Model\Mock');
    }

    public function test_usingModel_setsAttrs()
    {
        $this->assertInstanceOf('Mismatch\Model\AttrBag', $this->metadata['attrs']);
    }

    public function test_usingModel_setsAttrResolver()
    {
        $this->assertInstanceOf('Mismatch\Model\AttrResolver', $this->metadata['attr-resolver']);
    }
}

namespace Mismatch\Model;

use Mismatch;

class Mock
{
    use Mismatch\Model;
}
