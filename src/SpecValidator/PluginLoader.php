<?php

namespace SpecValidator;

/**
 *
 * PluginLoader
 *
 * @package SpecValidator
 * @subpackage SpecValidator\Validator
 * @copyright (c) Vicente Mendoza <chentepixtol@gmail.com>
 * @author chentepixtol
 *
 */
class PluginLoader
{

    /**
     *
     * @param string $plugin
     * @return boolean
     */
    public static function exists($plugin)
    {
        $className = self::getClassName($plugin);
        return (boolean) $className;
    }

    /**
     *
     * @param unknown_type $plugin
     * @return string
     */
    protected static function getClassName($plugin)
    {
        if( in_array($plugin, array('and', 'composite', 'not', 'optional', 'or', 'zend')) ){
            return false;
        }

        $className = __NAMESPACE__ . '\\Validator\\' . ucfirst($plugin) . 'Validator';
        if( class_exists($className) ){
            return $className;
        }

        $className = "Zend\\Validator\\" . ucfirst($plugin);
        if( class_exists($className) ){
            return $className;
        }

        return false;
    }


    /**
     *
     * @param string $plugin
     * @param array $args array
     */
    public static function factory($plugin, array $args = array(), $message = '')
    {
        $className = self::getClassName($plugin);
        if( !$className ){
            throw new \SpecValidator\Exception("El plugin no existe " .$plugin);
        }

        if( preg_match("/^Zend\\\\Validator/", $className) ){
            $args['validator'] = $className;
            $className = "SpecValidator\\Validator\\ZendValidator";
        }

        $reflectClass = new \ReflectionClass($className);
        return $reflectClass->newInstanceArgs(array($args, $message));
    }

}