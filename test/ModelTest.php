<?php

namespace Mismatch;

use Mismatch\Model\Metadata;

class ModelTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->metadata = new Metadata('Mismatch\Model\Mock');
    }

    public function test_usingModel_setsAttributes()
    {
        $this->assertInstanceOf('Mismatch\Model\AttributeBag', $this->metadata['attributes']);
    }
}

namespace Mismatch\Model;

use Mismatch;

class Mock
{
    use Mismatch\Model;
}
