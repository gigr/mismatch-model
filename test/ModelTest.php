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
        $this->assertInstanceOf('Mismatch\Model\AttrBag', $this->metadata['attr-bag']);
    }

    public function test_usingModel_setsAttrFactory()
    {
        $this->assertInstanceOf('Mismatch\Model\AttrFactory', $this->metadata['attr-factory']);
    }

    public function test_read_returnsValue()
    {
        $model = new Model\Mock();
        $model->write('foo', 'bar');

        $this->assertEquals('bar', $model->read('foo'));
    }
}

namespace Mismatch\Model;

use Mismatch;

class Mock
{
    use Mismatch\Model;
}
