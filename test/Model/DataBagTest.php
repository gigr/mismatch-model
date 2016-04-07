<?php

namespace Mismatch\Model;

class DataBagTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->subject = new DataBag([
            'original' => true
        ]);
    }

    public function test_has_worksForOriginalValues()
    {
        $this->assertTrue($this->subject->has('original'));
        $this->assertFalse($this->subject->has('invalid'));
    }

    public function test_has_worksForChangedValues()
    {
        $this->subject->set('original', false);
        $this->assertTrue($this->subject->has('original'));
    }

    public function test_get_worksForOriginalValues()
    {
        $this->assertTrue($this->subject->get('original'));
    }

    public function test_get_worksForChangeValues()
    {
        $this->subject->set('original', false);
        $this->assertFalse($this->subject->get('original'));
    }
}
