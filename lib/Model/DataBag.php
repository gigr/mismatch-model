<?php

/**
 * This file is part of Mismatch.
 *
 * @author   Jonathan Geiger <me@gigr.ca>
 * @license  MIT
 */
namespace Mismatch\Model;

/**
 * Holds the data for a model.
 */
class DataBag
{
    /**
     * @var  array  The raw array of values.
     */
    private $data = [];

    /**
     * @var  array  The changed values on the dataset.
     */
    private $changes = [];

    /**
     * Constructor.
     *
     * @param  array  $data  The original set of data for the dataset.
     */
    public function __construct($data = [])
    {
        $this->data = $data;
    }

    /**
     * Returns a JSON string of the data for debugging.
     *
     * @return  string
     */
    public function __toString()
    {
        return json_encode(array_merge($this->data, $this->changes));
    }

    /**
     * Reads a value from the dataset.
     *
     * @param   string  $name
     * @return  bool
     */
    public function has($name)
    {
        if (array_key_exists($name, $this->changes)) {
            return true;
        }

        if (array_key_exists($name, $this->data)) {
            return true;
        }

        return false;
    }

    /**
     * Reads a value from the dataset.
     *
     * @param   string  $name
     * @param   mixed   $default
     * @return  mixed
     */
    public function get($name, $default = null)
    {
        if (array_key_exists($name, $this->changes)) {
            return $this->changes[$name];
        }

        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }

        return $default;
    }

    /**
     * Changes a value or set of values on the dataset.
     *
     * @param   string  $name
     * @param   mixed   $value
     * @return  self
     */
    public function set($name, $value)
    {
        // Mark the field as unchanged if the value has not deviated
        // from the original value that the dataset holds. We get slightly
        // smarter change tracking this way.
        if (array_key_exists($name, $this->data) && $this->data[$name] === $value) {
            unset($this->changes[$name]);
            return;
        }

        $this->changes[$name] = $value;
    }
}
