<?php

namespace Mismatch\Model;

use Mockery;

class AttrResolverTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->attr = Mockery::mock('Mismatch\Model\AttrInterface');
        $this->metadata = new Metadata('stdClass');
        $this->subject = new AttrResolver($this->metadata);

        // Register a factory for use across all of the tests.
        $this->subject->factory('Integer', function($m, $opts) {
            return new Attr\MockInteger($m, $opts);
        });
    }

    public function test_resolve_handlesAttrInterfaces()
    {
        $this->assertSame($this->attr, $this->subject->resolve('test', $this->attr));
    }

    public function test_resolve_alias()
    {
        $attr = $this->subject->resolve('id', 'Integer');
        $this->assertMockInteger($attr, ['name' => 'id']);
    }

    public function test_resolve_alias__nullable()
    {
        $attr = $this->subject->resolve('id', 'Integer?');
        $this->assertMockInteger($attr, ['name' => 'id', 'nullable' => true]);
    }

    public function test_resolve_className()
    {
        $attr = $this->subject->resolve('id', 'Mismatch\Model\Attr\MockInteger');
        $this->assertMockInteger($attr, ['name' => 'id']);
    }

    public function test_resolve_className__nullable()
    {
        $attr = $this->subject->resolve('id', 'Mismatch\Model\Attr\MockInteger?');
        $this->assertMockInteger($attr, ['name' => 'id', 'nullable' => true]);
    }

    public function test_resolve_closure()
    {
        $attr = $this->subject->resolve('id', function($m, $opts) {
            return new Attr\MockInteger($m, array_merge($opts, ['called' => true]));
        });

        $this->assertMockInteger($attr, ['name' => 'id', 'called' => true]);
    }

    public function test_resolve_array_typeAsFirstElement()
    {
        $attr = $this->subject->resolve('id', ['Integer', 'nullable' => true]);
        $this->assertMockInteger($attr, ['name' => 'id', 'nullable' => true]);
    }

    public function test_resolve_array_typeAsKey()
    {
        $attr = $this->subject->resolve('id', ['type' => 'Integer', 'nullable' => true]);
        $this->assertMockInteger($attr, ['name' => 'id', 'nullable' => true]);
    }

    private function assertMockInteger($attr, array $opts = [])
    {
        $this->assertInstanceOf('Mismatch\Model\Attr\MockInteger', $attr);
        $this->assertSame($this->metadata, $attr->metadata);
        $this->assertEquals('id', $attr->opts['name']);

        foreach ($opts as $key => $value) {
            $this->assertEquals($value, $attr->opts[$key]);
        }
    }
}

namespace Mismatch\Model\Attr;

use Mismatch\Model\AttrInterface;

class MockInteger implements AttrInterface
{
    public function __construct($metadata, array $opts)
    {
        $this->metadata = $metadata;
        $this->opts = $opts;
    }

    public function write($model, $value)
    {
        // Stubbed for test...
    }

    public function read($model, $value)
    {
        // Stubbed for test...
    }

    public function deserialize($result, $value)
    {
        // Stubbed for test...
    }

    public function serialize($model, $old, $new)
    {
        // Stubbed for test...
    }
}
