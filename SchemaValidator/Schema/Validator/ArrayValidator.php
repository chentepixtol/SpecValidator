<?php


namespace Schema\Validator;

class ArrayValidator extends Composite
{

	/**
	 *
	 * @var Validator
	 */
	protected $validator;

	/**
	 *
	 * @param array $validators
	 */
	public function __construct($validator){
		$this->validator = $validator;
	}

	/**
	 * (non-PHPdoc)
	 * @see Schema\Validator.Validator::isValid()
	 */
	public function isValid($value)
	{
		$this->clearErrors();

		if( !is_array($value) ){
			$this->addError("El valor propocionado no es un array");
			return false;
		}

		$isValid = true;
		foreach ($value as $val){
			if ( !$this->validator->isValid($val) ){
				$this->addError($this->validator->getErrors());
				$isValid = false;
			}
		}

		return $isValid;
	}


}