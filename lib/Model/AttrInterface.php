<?php

/**
 * This file is part of Mismatch.
 *
 * @author   Jonathan Geiger <me@gigr.ca>
 * @license  MIT
 */
namespace Mismatch\Model;

/**
 * Interface that all Mismatch attributes must adhere to.
 */
interface AttrInterface
{
    /**
     * Constructor.
     *
     * @param   Mismatch\Model\Metadata  $metadata
     * @param   array                    $opts
     */
    public function __construct($metadata, array $opts);

    /**
     * Called when reading a value from a model.
     *
     * @param   Mismatch\Model  $model
     * @return  mixed
     */
    public function read($model);

    /**
     * Called when writing a value to the model in PHP land.
     *
     * @param   Mismatch\Model  $model
     * @param   mixed           $value
     */
    public function write($model, $value);
}
