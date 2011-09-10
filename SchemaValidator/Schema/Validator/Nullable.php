<?php


namespace Schema\Validator;

class Nullable extends Composite
{

	/**
	 * (non-PHPdoc)
	 * @see Schema\Validator.Validator::isValid()
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