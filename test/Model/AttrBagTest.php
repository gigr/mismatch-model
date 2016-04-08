<?php

namespace Mismatch\Model;

use Mockery;

class AttrBagTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->subject = new AttrBag();
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
}
