<?php

namespace Mismatch\Model;

class MetadataTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->subject = new Metadata('Mismatch\Model\Metadata\Mock');
    }

    public function test_get_returnsSameInstance()
    {
        $this->assertSame(Metadata::get('Mismatch\Model\Metadata\Mock'),
                          Metadata::get('Mismatch\Model\Metadata\Mock'));
    }

    public function test_constructor_callChain()
    {
        $this->assertEquals($this->subject['calls'], [
            'MockNestedTrait::usingMockNestedTrait',
            'MockTrait::usingMockTrait',
            'MockParentTrait::usingMockParentTrait',
            'Mock::init',
        ]);
    }
}

namespace Mismatch\Model\Metadata;

function addCall($m, $name)
{
    if (!isset($m['calls'])) {
        $m['calls'] = [];
    }

    $m['calls'] = array_merge($m['calls'], [$name]);
}

trait MockNestedTrait
{
    public static function usingMockNestedTrait($m)
    {
        addCall($m, 'MockNestedTrait::usingMockNestedTrait');
    }
}

trait MockTrait
{
    use MockNestedTrait;

    public static function usingMockTrait($m)
    {
        addCall($m, 'MockTrait::usingMockTrait');
    }
}

trait MockParentTrait
{
    public static function usingMockParentTrait($m)
    {
        addCall($m, 'MockParentTrait::usingMockParentTrait');
    }
}

class MockGrandParent
{
    use MockTrait;
}

class MockParent extends MockGrandParent
{
    use MockParentTrait;
}

class Mock extends MockParent
{
    use MockTrait;

    public static function init($m)
    {
        addCall($m, 'Mock::init');
    }
}
