<?php

/**
 * This file is part of Mismatch.
 *
 * @author   Jonathan Geiger <me@gigr.ca>
 * @license  MIT
 */
namespace Mismatch\Model\Attr;

use InvalidArgumentException;

/**
 * A helpful base class for all attributes.
 */
abstract class Base implements AttrInterface
{
    /**
     * The name of the attribute, which dictates the key that it is
     * retrieved and stored under.
     *
     * @var  string
     */
    protected $name;

    /**
     * Whether or not the attribute is nullable. If it is true, then
     * "null"s written to the model will be written untouched.
     *
     * @var  bool
     */
    protected $nullable = false;

    /**
     * A default value for the attribute.
     *
     * @var  mixed
     */
    protected $default;

    /**
     * The metadata of the model owning this attribute.
     *
     * @var  Mismatch\Model\Metadata
     */
    protected $metadata;

    /**
     * Constructor.
     *
     * @param  string  $name
     * @param  array   $opts
     */
    public function __construct($metadata, array $opts = [])
    {
        $this->metadata = $metadata;

        foreach ($opts as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function __get($name)
    {
        return $this->$name;
    }
}
