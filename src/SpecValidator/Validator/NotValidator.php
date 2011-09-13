<?php

namespace SpecValidator\Validator;

/**
 *
 * NotValidator
 *
 * @package SpecValidator
 * @subpackage SpecValidator\Validator
 * @copyright (c) Vicente Mendoza <chentepixtol@gmail.com>
 * @author chentepixtol
 *
 */
class NotValidator extends CompositeValidator
{

	/**
	 * (non-PHPdoc)
	 * @see SpecValidator\Validator.ValidatorInterface::isValid()
	 */
	public function isValid($value)
	{
		$this->clearErrors();
		$isValid = false;
		$validator = $this->getOne();
		if( $validator->isValid($value) ){
			$this->addError($validator->getErrors());
			$isValid = true;
		}

		return !$isValid;
	}

}