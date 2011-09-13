<?php

namespace SpecValidator\Validator;

/**
 *
 * CompositeValidator
 *
 * @package SpecValidator
 * @subpackage SpecValidator\Validator
 * @copyright (c) Vicente Mendoza <chentepixtol@gmail.com>
 * @author chentepixtol
 *
 */
abstract class CompositeValidator extends Validator
{

	/**
	 *
	 * @var array
	 */
	protected $validators = array();

	/**
	 *
	 * @param array $validators
	 */
	public function __construct($validators)
	{
		$this->setValidators(is_array($validators) ? $validators : array($validators));
	}

	/**
	 * @return array
	 */
	public function getValidators(){
		return $this->validators;
	}

	/**
	 * @param array $validators
	 */
	public function setValidators(array $validators) {
		$this->validators = $validators;
	}

	/**
	 *
	 * @return int
	 */
	public function count(){
		return count($this->validators);
	}

	/**
	 *
	 * @return boolean
	 */
	public function isEmpty(){
		return $this->count() == 0;
	}

	/**
	 *
	 * @return ValidatorInterface
	 */
	public function getOne()
	{
		reset($this->validators);
		return current($this->validators);
	}

}