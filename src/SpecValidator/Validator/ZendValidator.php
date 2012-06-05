<?php

namespace SpecValidator\Validator;

/**
 *
 * ZendValidateAdapter
 *
 * @package SpecValidator
 * @subpackage SpecValidator\Validator
 * @copyright (c) Vicente Mendoza <chentepixtol@gmail.com>
 * @author chentepixtol
 *
 */
class ZendValidator extends Validator
{

    /**
     *
     *
     * @var string
     */
    protected $classBaseName;

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
        $this->setMessage($message);
        $this->setOptions($options);
    }

    /**
     * (non-PHPdoc)
     * @see SpecValidator\Validator.Validator::isValid()
     */
    public function isValid($value){
        $this->clearErrors();
        $this->lastValue = $value;
        return \Zend\Validator\StaticValidator::execute($value, $this->classBaseName, $this->getOptions());
    }

    /**
     * (non-PHPdoc)
     * @see SpecValidator\Validator.Composite::getErrors()
     */
    public function getErrors(){
        return str_replace('%value%', $this->lastValue, $this->getMessage());
    }

}