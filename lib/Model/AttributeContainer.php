<?php

/**
 * This file is part of Mismatch.
 *
 * @author   Jonathan Geiger <me@gigr.ca>
 * @license  MIT
 */
namespace Mismatch\Model;

use Mismatch\Model\AttributeInterface;
use InvalidArgumentException;
use IteratorAggregate;
use ArrayIterator;

/**
 * Manages access to a model's attributes.
 */
class AttributeContainer implements IteratorAggregate
{
    /**
     * @var  array
     */
    private $attrs = [];

    /**
     * @return  string
     */
    public function __toString()
    {
        return sprintf('%s:%s', get_class($this), json_encode(array_keys($this->attrs)));
    }

    /**
     * Adds a new attribute to the bag.
     *
     * Attributes must have a name and type, which can be
     * in a few forms:
     *
     *  - An AttributeInterface object.
     *
     * @param  string  $name
     * @param  mixed   $type
     */
    public function set($name, AttributeInterface $type)
    {
        $this->attrs[$name] = $type;
    }

    /**
     * Returns an attribute from the bag.
     *
     * @param   string  $name
     * @return  AttributeInterface
     * @throws  InvalidArgumentException
     */
    public function get($name)
    {
        if (!$this->has($name)) {
            throw new InvalidArgumentException();
        }

        return $this->attrs[$name];
    }

    /**
     * Returns whether or not an attribute has been added to the bag.
     *
     * @param   string  $name
     * @return  bool
     */
    public function has($name)
    {
        return isset($this->attrs[$name]);
    }

    /**
     * Allows iterating over the list of types.
     *
     * @return  ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->attrs);
    }
}
