<?php


namespace Schema\Validator;

class OrValidator extends Composite
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
		if( count($this->validators) == 0 ){
			return true;
		}

		$isValid = false;
		foreach( $this->validators as $validator ){
			if( $validator instanceof Validator ){
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