<?php

namespace Mismatch\Model\Attr;

use Mockery;
use StdClass;

trait PrimitiveTestCase
{
    public function testRead_nullable()
    {
        $model = $this->createModel();
        $model->shouldReceive('read')
            ->with('test')
            ->andReturn(null);

        $subject = $this->createSubject($this->createMetadata(), [
            'name' => 'test',
            'nullable' => true,
        ]);

        $this->assertNull($subject->read($model));
    }

    public function testRead_default()
    {
        $model = $this->createModel();
        $model->shouldReceive('read')
            ->with('test')
            ->andReturn(null);

        $default = new StdClass();
        $subject = $this->createSubject($this->createMetadata(), [
            'default' => $default,
            'nullable' => false,
            'name' => 'test',
        ]);

        $this->assertEquals($default, $subject->read($model));
    }

    public function testRead_default_callable()
    {
        $model = $this->createModel();
        $model->shouldReceive('read')
            ->with('test')
            ->andReturn(null);

        $default = new StdClass();
        $subject = $this->createSubject($this->createMetadata(), [
            'name' => 'test',
            'default' => function () use ($default) {
                return $default;
            },
        ]);

        $this->assertSame($default, $subject->read($model));
    }

    public function testRead_value()
    {
        $model = $this->createModel();
        $model->shouldReceive('read')
            ->with('test')
            ->andReturn('now');

        $subject = $this->createSubject($this->createMetadata(), [
            'name' => 'test'
        ]);

        $this->assertNotNull($subject->read($model));
    }

    public function testWrite_nullable()
    {
        $model = $this->createModel();
        $model->shouldReceive('write')
            ->with('test', null);

        $subject = $this->createSubject($this->createMetadata(), [
            'nullable' => true,
            'name' => 'test',
        ]);

        $this->assertNull($subject->write($model, null));
    }

    public function testWrite_value()
    {
        $model = $this->createModel();
        $model->shouldReceive('write')
            ->with('test', Mockery::not(null));

        $subject = $this->createSubject($this->createMetadata(), [
            'name' => 'test'
        ]);

        $subject->write($model, 'now');
    }

    public function createModel()
    {
        return Mockery::mock('Mismatch\Model\Mock\PrimitiveAttrMock');
    }

    public function createMetadata()
    {
        return Mockery::mock('Mismatch\Model\Metadata');
    }

    abstract public function createSubject($metadata, array $opts = []);
}

namespace Mismatch\Model\Mock;

use Mismatch\Model;

class PrimitiveAttrMock
{
    use Model;
}
