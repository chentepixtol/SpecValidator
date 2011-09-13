<?php

namespace SpecValidator\Validator;

/**
 *
 * OrValidator
 *
 * @package SpecValidator
 * @subpackage SpecValidator\Validator
 * @copyright (c) Vicente Mendoza <chentepixtol@gmail.com>
 * @author chentepixtol
 *
 */
class OrValidator extends CompositeValidator
{

	/**
	 * (non-PHPdoc)
	 * @see SpecValidator\Validator.ValidatorInterface::isValid()
	 */
	public function isValid($value)
	{
		$this->clearErrors();
		$isValid = false;
		foreach( $this->getValidators() as $validator ){
			if( $validator instanceof ValidatorInterface ){
				if( $validator->isValid($value) ){
					$isValid = true;
				}
				else{
					$this->addError($validator->getErrors());
				}
			}
		}
		return $isValid;
	}

}