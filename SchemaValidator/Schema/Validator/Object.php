<?php


namespace Schema\Validator;

class Object extends Composite
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
	public function __construct($validators){
		$this->validators = $validators;
	}

	/**
	 * (non-PHPdoc)
	 * @see Schema\Validator.Validator::isValid()
	 */
	public function isValid($value)
	{
		$isValid = true;
		foreach ($this->validators as $property => $validator)
		{
			$val = isset($value[$property]) ? $value[$property] : null;

			if( $validator instanceof Validator && !$validator->isValid($val)){
				$this->addError($validator->getErrors());
				$isValid = false;
			}
		}
		return $isValid;
	}


}