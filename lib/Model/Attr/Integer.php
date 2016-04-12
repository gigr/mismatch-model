<?php

/**
 * This file is part of Mismatch.
 *
 * @author   Jonathan Geiger <me@gigr.ca>
 * @license  MIT
 */
namespace Mismatch\Model\Attr;

/**
 * A type for integer attributes.
 */
class Integer extends Primitive
{
    /**
     * {@inheritDoc}
     */
    protected $default = 0;

    /**
     * {@inheritDoc}
     */
    public function cast($value)
    {
        return (int) $value;
    }
}
