<?php


namespace Schema\Validator;

abstract class Composite implements Validator
{
	/**
	 *
	 * @var array
	 */
	protected $errors = array();

	/**
	 * (non-PHPdoc)
	 * @see Schema\Validator.Validator::addOR()
	 */
	public function addOR($validator)
	{
		if( func_num_args() != 1 ){
			$validator = func_get_args();
		}

		return new OrValidator($this->getArgs($validator));
	}

	/**
	 * (non-PHPdoc)
	 * @see Schema\Validator.Validator::addAND()
	 */
	public function addAND($validator)
	{
		if( func_num_args() != 1 ){
			$validator = func_get_args();
		}

		return new AndValidator($this->getArgs($validator));
	}

	/**
	 * (non-PHPdoc)
	 * @see Schema\Validator.Validator::not()
	 */
	public function not(){
		return new NotValidator($this);
	}

	/**
	 *
	 *
	 * @param mixed $args
	 * @return array
	 */
	protected function getArgs($args)
	{
		if( is_array($args) ){
			$args[] = $this;
		}else if ( $args instanceof Validator ) {
			$args = array($args, $this);
		}
		return $args;
	}

	public function addError($error)
	{
		if( is_array($error) ){
			$this->errors = array_merge($this->errors, $error);
		}else{
			$this->errors[] = $error;
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see Schema\Validator.Validator::getErrors()
	 */
	public function getErrors(){
		return $this->errors;
	}


}