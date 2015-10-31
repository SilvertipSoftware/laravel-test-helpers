<?php namespace SilvertipSoftware\LaravelTestHelpers;

use \Illuminate\Database\Eloquent\Model as Eloquent;
use \Illuminate\Validation\DatabasePresenceVerifier;
use \Symfony\Component\Translation\Translator;

// fake Validator for testing
// to use, make a dummy subclass in the top level namespace
class ValidatorHelper {

    protected static $factory;

    public static function instance()
    {
        if ( ! static::$factory)
        {
            $translator = new Translator('en');
            static::$factory = new \Illuminate\Validation\Factory($translator);
            static::$factory->setPresenceVerifier( new DatabasePresenceVerifier( Eloquent::getConnectionResolver() ) );
        }

        return static::$factory;
    }

    public static function __callStatic($method, $args)
    {
        $instance = static::instance();

        switch (count($args))
        {
            case 0:
                return $instance->$method();

            case 1:
                return $instance->$method($args[0]);

            case 2:
                return $instance->$method($args[0], $args[1]);

            case 3:
                return $instance->$method($args[0], $args[1], $args[2]);

            case 4:
                return $instance->$method($args[0], $args[1], $args[2], $args[3]);

            default:
                return call_user_func_array(array($instance, $method), $args);
        }
    }
}
