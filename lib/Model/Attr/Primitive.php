<?php

/**
 * This file is part of Mismatch.
 *
 * @author   Jonathan Geiger <me@gigr.ca>
 * @license  MIT
 */
namespace Mismatch\Model\Attr;

/**
 * A helpful base class for attributes that represent primitive types.
 */
abstract class Primitive extends Base
{
    /**
     * {@inheritDoc}
     */
    public function read($model)
    {
        $value = $model->read($this->name);

        if ($value === null) {
            return $this->nullable ? null : $this->getDefault($model);
        }

        return $this->cast($value);
    }

    /**
     * {@inheritDoc}
     */
    public function write($model, $value)
    {
        if ($value !== null || !$this->nullable) {
            $value = $this->cast($value);
        }

        $model->write($this->name, $value);
    }

    /**
     * Should return the value casted to an appropriate type.
     *
     * @param  mixed  $value
     * @return mixed
     */
    abstract public function cast($value);

    /**
     * Should return the default value for the type.
     *
     * @return mixed
     */
    protected function getDefault($model)
    {
        if (is_callable($this->default)) {
            return call_user_func($this->default, $model);
        }

        return $this->default;
    }
}
