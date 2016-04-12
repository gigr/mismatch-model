<?php

/**
 * This file is part of Mismatch.
 *
 * @author   Jonathan Geiger <me@gigr.ca>
 * @license  MIT
 */
namespace Mismatch\Model\Attr;

/**
 * A type for set attributes.
 */
class Set extends Primitive
{
    /**
     * {@inheritDoc}
     */
    protected $default = [];

    /**
     * {@inheritDoc}
     */
    public function cast($value)
    {
        return (array) $value;
    }
}
