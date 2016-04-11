<?php

namespace Mismatch\Model;

use Mockery;

class AttrBagTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->factory = Mockery::mock('Mismatch\Model\AttrFactory');
        $this->subject = new AttrBag($this->factory);
        $this->subject->set('integer', Mockery::mock('Mismatch\Model\AttrInterface'));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_get_invalidAttr()
    {
        $this->subject->get('invalid');
    }

    public function test_has_invalidAttr()
    {
        $this->assertFalse($this->subject->has('invalid'));
    }

    public function test_has_validAttr()
    {
        $this->assertTrue($this->subject->has('integer'));
    }

    public function test_get_validAttr()
    {
        $attr = $this->subject->get('integer');

        $this->assertInstanceOf('Mismatch\Model\AttrInterface', $attr);
    }

    public function test_get_remainsCached()
    {
        $attr1 = $this->subject->get('integer');
        $attr2 = $this->subject->get('integer');

        $this->assertInstanceOf('Mismatch\Model\AttrInterface', $attr1);
        $this->assertInstanceOf('Mismatch\Model\AttrInterface', $attr2);
        $this->assertSame($attr1, $attr2);
    }

    public function test_get_delegatesToFactory()
    {
        $mockAttr = Mockery::mock('Mismatch\Model\AttrInterface');

        $this->factory
            ->shouldReceive('build')
            ->with('factory', 'Factory')
            ->andReturn($mockAttr)
            ->once();

        $this->subject->set('factory', 'Factory');

        // This is an implementation detail, but we should only call
        // the factory once. Once cached, there's no need to re-build.
        $this->assertSame($mockAttr, $this->subject->get('factory'));
        $this->assertSame($mockAttr, $this->subject->get('factory'));
    }
}
