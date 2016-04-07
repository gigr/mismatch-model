<?php

namespace Mismatch\Model;

use Mockery;

class AttributeContainerTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->subject = new AttributeContainer();
        $this->subject->set('integer', Mockery::mock('Mismatch\Model\AttributeInterface'));
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

        $this->assertInstanceOf('Mismatch\Model\AttributeInterface', $attr);
    }

    public function test_get_remainsCached()
    {
        $attr1 = $this->subject->get('integer');
        $attr2 = $this->subject->get('integer');

        $this->assertInstanceOf('Mismatch\Model\AttributeInterface', $attr1);
        $this->assertInstanceOf('Mismatch\Model\AttributeInterface', $attr2);
        $this->assertSame($attr1, $attr2);
    }
}
