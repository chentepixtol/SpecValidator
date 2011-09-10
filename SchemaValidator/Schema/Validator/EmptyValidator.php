<?php


namespace Schema\Validator;

class EmptyValidator extends Composite
{

	/**
	 * (non-PHPdoc)
	 * @see Schema\Validator.Validator::isValid()
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