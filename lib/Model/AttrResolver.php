<?php

/**
 * This file is part of Mismatch.
 *
 * @author   Jonathan Geiger <me@gigr.ca>
 * @license  MIT
 */
namespace Mismatch\Model;

class AttrResolver
{
    /**
     * @var  Metadata  $metadata
     */
    private $metadata;

    /**
     * @var  array  $factories
     */
    private $factories;

    /**
     * Constructor.
     *
     * @param  Metadata  $metadata
     * @param  array     $factories
     */
    public function __construct(Metadata $metadata, array $factories = [])
    {
        $this->metadata = $metadata;
        $this->factories = $factories;
    }

    /**
     * Registers a type factory.
     *
     * @param  string          $alias
     * @param  string|Closure  $factory
     */
    public function factory($name, $factory)
    {
        $this->factories[$name] = $factory;
    }

    /**
     * Resolves an attribute to its constructed instance.
     *
     * Many formats are accepted for a valid result to be returned, including:
     *
     *  - A registered type, like "Integer".
     *  - A valid class name, like "Foo\Bar\MyAttr".
     *  - A nullable type, like "Integer?".
     *  - An AttrInterface object.
     *  - An array where the first key is any of the above, like
     *    ["Array", "each" => "Integer"]
     *  - An array where a type key is any of the above, like
     *    ["type" => "String?", "default" => "hi!"]
     *  - A callable, like function($metadata, array $opts)
     *
     * @param  string  $name   The name of the attribute we're building
     * @param  mixed   $opts   Options passed to the constructed attribute
     */
    public function resolve($name, $opts)
    {
        // Already built, so just return it.
        if ($opts instanceof AttrInterface) {
            return $opts;
        }

        $opts = $this->normalizeOpts($name, $opts);
        $class = $opts['type'];

        // Allow types to be factories that can generate instances.
        // This allows more robust customization than simple instances.
        if (is_callable($class)) {
            return call_user_func($class, $this->metadata, $opts);
        } else {
            return new $class($this->metadata, $opts);
        }
    }

    /**
     * @param  string  $name
     * @param  mixed   $opts
     */
    private function normalizeOpts($name, $opts)
    {
        // Allow passing a bare string or function for the type.
        // We can figure out the rest for the user.
        if (!is_array($opts)) {
            $opts = ['type' => $opts];
        }

        // Allow passing an array where the first value, regardless
        // of key, is the attribute type to use. This looks pretty.
        if (is_array($opts) && is_int(key($opts))) {
            $opts['type'] = $opts[key($opts)];
            unset($opts[key($opts)]);
        }

        // Ensure the name is part of the opts payload.
        // Most attributes need this to function.
        $opts['name'] = $name;

        if (empty($opts['type'])) {
            throw new InvalidArgumentException();
        }

        // If we have a string for the type, it might be some sort
        // of alias, so parse it out and return the results.
        if (is_string($opts['type'])) {
            $opts = $this->parseType($opts);
        }

        return $opts;
    }

    /**
     * @param   array $opts
     * @return  array
     */
    private function parseType(array $opts)
    {
        $pattern = "/^(?<type>[\w\\\]+)(?<nullable>\?)?$/";

        if (false === preg_match($pattern, $opts['type'], $matches)) {
            throw new InvalidArgumentException();
        }

        // Resolve the type with the already declared types.
        $opts['type'] = $this->resolveType($matches['type']);

        // Parse strings like "Foo" or "Foo?". A question mark at
        // the end of a string indicates the type is nullable.
        if (!empty($matches['nullable'])) {
            $opts['nullable'] = true;
        }

        return $opts;
    }

    /**
     * @param  string  $type
     * @return string
     */
    private function resolveType($type)
    {
        return isset($this->factories[$type]) ? $this->factories[$type] : $type;
    }
}
