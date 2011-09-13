<?php

namespace SpecValidator\Validator;

/**
 *
 * ArrayAssocValidator
 *
 * @package SpecValidator
 * @subpackage SpecValidator\Validator
 * @copyright (c) Vicente Mendoza <chentepixtol@gmail.com>
 * @author chentepixtol
 *
 */
class ArrayAssocValidator extends CompositeValidator
{

	/**
	 * (non-PHPdoc)
	 * @see SpecValidator\Validator.ValidatorInterface::isValid()
	 */
	public function isValid($value)
	{
		$this->clearErrors();
		$isValid = true;
		foreach ($this->getValidators() as $property => $validator)
		{
			$val = isset($value[$property]) ? $value[$property] : null;

			if( $validator instanceof ValidatorInterface && !$validator->isValid($val)){
				$this->addError($validator->getErrors());
				$isValid = false;
			}
		}
		return $isValid;
	}


}