<?php
namespace Schema\Validator;

class ZendValidateAdapter extends Composite
{

	/**
	 *
	 *
	 * @var string
	 */
	protected $classBaseName;

	/**
	 *
	 *
	 * @var array
	 */
	protected $options = array();

	/**
	 *
	 * @var string
	 */
	protected $message;

	/**
	 *
	 * @var mixed
	 */
	protected $lastValue;

	/**
	 *
	 *
	 * @param string $classBaseName
	 * @param array $options
	 */
	public function __construct($classBaseName, $message = null, array $options = array()){
		$this->classBaseName = $classBaseName;
		$this->message = $message;
		$this->options = $options;
	}

	/**
	 * (non-PHPdoc)
	 * @see Schema\Validator.Validator::isValid()
	 */
	public function isValid($value){
		$this->clearErrors();
		$this->lastValue = $value;
		return \Zend_Validate::is($value, $this->classBaseName, $this->options);
	}

	/**
	 * (non-PHPdoc)
	 * @see Schema\Validator.Composite::getErrors()
	 */
	public function getErrors(){
		return str_replace('%value%', $this->lastValue, $this->message);
	}

}