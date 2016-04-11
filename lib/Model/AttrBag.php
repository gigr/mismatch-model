<?php

/**
 * This file is part of Mismatch.
 *
 * @author   Jonathan Geiger <me@gigr.ca>
 * @license  MIT
 */
namespace Mismatch\Model;

use Mismatch\Model\AttrInterface;
use InvalidArgumentException;

/**
 * Manages access to a model's attributes.
 */
class AttrBag
{
    /**
     * @var  array
     */
    private $attrs = [];

    /**
     * @var  AttrResolver
     */
    private $resolver;

    /**
     * @param  AttrResolver  $resolver
     */
    public function __construct($resolver)
    {
        $this->resolver = $resolver;
    }

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
     *  - An resolvable attribute type.
     *
     * @param  string  $name
     * @param  mixed   $type
     */
    public function set($name, $type)
    {
        $this->attrs[$name] = $type;
    }

    /**
     * Returns an attribute from the bag.
     *
     * @param   string  $name
     * @return  AttrInterface
     * @throws  InvalidArgumentException
     */
    public function get($name)
    {
        if (!$this->has($name)) {
            throw new InvalidArgumentException();
        }

        if (!($this->attrs[$name] instanceof AttrInterface)) {
            $this->attrs[$name] = $this->resolve($name);
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
     * @param   string
     * @return  AttrInterface
     */
    private function resolve($name)
    {
        return $this->resolver->resolve($name, $this->attrs[$name]);
    }
}
