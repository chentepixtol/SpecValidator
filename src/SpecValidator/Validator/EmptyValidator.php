<?php

namespace SpecValidator\Validator;

/**
 *
 * EmptyValidator
 *
 * @package SpecValidator
 * @subpackage SpecValidator\Validator
 * @copyright (c) Vicente Mendoza <chentepixtol@gmail.com>
 * @author chentepixtol
 *
 */
class EmptyValidator extends Validator
{

	/**
	 * (non-PHPdoc)
	 * @see SpecValidator\Validator.ValidatorInterface::isValid()
	 */
	public function isValid($value)
	{
		$this->clearErrors();

		if( empty($value) ){
			return true;
		}

		return false;
	}


}