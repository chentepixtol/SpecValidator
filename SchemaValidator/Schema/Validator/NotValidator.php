<?php


namespace Schema\Validator;

class NotValidator extends Composite
{

	/**
	 *
	 *
	 * @var Validator
	 */
	protected $validator;

	/**
	 *
	 * @param Validator $validator
	 */
	public function __construct(Validator $validator){
		$this->validator = $validator;
	}

	/**
	 * (non-PHPdoc)
	 * @see Schema\Validator.Validator::isValid()
	 */
	public function isValid($value)
	{
		$this->clearErrors();
		if( !$this->validator->isValid($value) ){
			$this->addError($this->validator->getErrors());
			return false;
		}

		return true;
	}

}