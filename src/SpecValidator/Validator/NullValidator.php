<?php

namespace SpecValidator\Validator;

/**
 *
 * NullValidator
 *
 * @package SpecValidator
 * @subpackage SpecValidator\Validator
 * @copyright (c) Vicente Mendoza <chentepixtol@gmail.com>
 * @author chentepixtol
 *
 */
class NullValidator extends Validator
{

	/**
	 * (non-PHPdoc)
	 * @see SpecValidator\Validator.ValidatorInterface::isValid()
	 */
	public function isValid($value)
	{
		$this->clearErrors();

		if( is_null($value) ){
			return true;
		}

		return false;
	}


}