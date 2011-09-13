<?php

namespace SpecValidator\Validator;

/**
 *
 * ValidatorRegistry
 *
 * @package SpecValidator
 * @subpackage SpecValidator\Validator
 * @copyright (c) Vicente Mendoza <chentepixtol@gmail.com>
 * @author chentepixtol
 *
 */
class ValidatorRegistry
{

	/**
	 *
	 *
	 * @var array
	 */
	protected static $validators = array();

	/**
	 *
	 * register
	 * @param string $name
	 * @param ValidatorInterface $validator
	 */
	public static function register($name, ValidatorInterface $validator){
		self::$validators[$name] = $validator;
	}

	/**
	 *
	 * register
	 * @param array $validators
	 */
	public static function registerFromArray(array $validators)
	{
		foreach ($validators as $name => $validator){
			self::register($name, $validator);
		}
	}

	/**
	 *
	 * Has validator
	 * @param string $name
	 * @return boolean
	 */
	public static function has($name){
		return isset(self::$validators[$name]);
	}

	/**
	 *
	 * get one validator
	 * @param string $name
	 * @return ValidatorInterface
	 */
	public static function get($name)
	{
		if( ! self::has($name) ){
			return null;
		}
		return self::$validators[$name];
	}

	/**
	 *
	 * @return \Closure
	 */
	public static function getter()
	{
		static $getter = null;

		if( null == $getter){
			$getter = function ($name){
				return ValidatorRegistry::get($name);
			};
		}
		return $getter;
	}

}