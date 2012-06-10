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
     * @param array $options
     * @param string $message
     */
    public function __construct(array $options = array(), $message = 'The value "%value%" is wrong'){
        $this->classBaseName = $options['validator'];
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

        $isValid = \Zend\Validator\StaticValidator::execute($value, $this->classBaseName, $this->getOptions());

        if( !$isValid ){
            $this->addError(str_replace('%value%', (string) $this->lastValue, $this->getMessage()));
        }

        return $isValid;
    }

}