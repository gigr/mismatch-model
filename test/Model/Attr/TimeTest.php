<?php

namespace Mismatch\Model\Attr;

class TimeTest extends \PHPUnit_Framework_TestCase
{
    use PrimitiveTestCase;

    public function createSubject($metadata, $opts = [])
    {
        return new Time($metadata, $opts);
    }

    public function testRead_timeParsing()
    {
        $model = $this->createModel();
        $model->shouldReceive('read')
            ->with('test')
            ->andReturn('now');

        $subject = $this->createSubject($this->createMetadata(), [
            'name' => 'test',
        ]);

        $this->assertInstanceOf('DateTime', $subject->read($model));
    }
}
