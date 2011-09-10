<?php


namespace Schema\Validator;

class AndValidator extends Composite
{

	/**
	 *
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
		$this->clearErrors();
		$isValid = true;
		foreach( $this->validators as $validator ){
			if( $validator instanceof Validator && !$validator->isValid($value) ){
				$this->addError($validator->getErrors());
				$isValid = false;
			}
		}
		return $isValid;
	}

}