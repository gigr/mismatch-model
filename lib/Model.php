<?php

/**
 * This file is part of Mismatch.
 *
 * @author   Jonathan Geiger <me@gigr.ca>
 * @license  MIT
 */
namespace Mismatch;

use Mismatch\Model\AttrBag;
use InvalidArgumentException;

/**
 * Adds model-like functionality to a class.
 *
 * Mismatch models work by including traits that add extra features
 * to them. This trait adds the basic features you'd expect on any
 * model. For example:
 *
 *  - The ability to define attributes
 *  - Magic getters and setters
 *  - Change and state tracking
 *  - And more.
 *
 * As an example, let's define a model that represents users in our
 * application.
 *
 * ```php
 * class User
 * {
 *     user Mismatch\Model;
 *
 *     public static function init($m)
 *     {
 *         $m->email = new String($m);
 *         $m->firstName = new String($m);
 *         $m->lastName = new String($m, ['null' => true]);
 *         $m->created = new Time($m, ['default' => 'now']);
 *     }
 * }
 * ```
 *
 * As you can see, all it takes is declaring a class, including the
 * `Mismatch\Model` trait, and defining attributes on the model.  You
 * can specify the types for each attribute, as well as more complex
 * properties of the attribute, such as whether or not it is nullable
 * or the default to use.
 *
 * After declaring a model, you get to interact with it.
 *
 * ```php
 * $user = new User();
 * $user->email = 'h.donna.gust@example.com',
 * $user->firstName = 'H. Donna';
 * $user->lastName = 'Gust';
 * ```
 *
 * That's all there is to it!
 *
 * ## Metadata
 *
 * All models are backed by an instance of `Mismatch\Model\Metadata`. This
 * is a `Pimple` container that holds all sort of information about the model—
 * its name, its class, its attributes, and more.
 *
 * The first time you access a model its metadata is loaded up and configured
 * and the special `init` hook is called, allowing you (as well as other traits)
 * the ability to add and modify its metadata instance. This is where the real
 * power of Mismatch comes into play—as it's incredibly easy for new traits to
 * add and extend the functionality of your model.
 *
 * Take a look at [the Pimple docs](pimple.sensiolabs.org) for more information
 * on how to interact with the container.
 */
trait Model
{
    /**
     * Hook for when this trait is used on a class.
     *
     * @param  Metadata  $m
     */
    public static function usingModel($m)
    {
        $m['attrs'] = function($m) {
            return new AttrBag($m);
        };
    }

    /**
     * @var  array  The dataset that holds all of this model's data
     */
    private $data;

    /**
     * @var  AttrBag  The attribute bag that holds all of this model's attrs.
     */
    private $attrs;
}
