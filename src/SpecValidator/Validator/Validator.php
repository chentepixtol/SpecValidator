<?php

namespace SpecValidator\Validator;

use SpecValidator\PluginLoader;

/**
 *
 * Validator
 *
 * @package SpecValidator
 * @subpackage SpecValidator\Validator
 * @copyright (c) Vicente Mendoza <chentepixtol@gmail.com>
 * @author chentepixtol
 *
 */
abstract class Validator implements ValidatorInterface
{
    /**
     *
     * @var array
     */
    protected $errors = array();

    /**
     *
     * @var array
     */
    protected $options = array();

    /**
     *
     * @var string
     */
    protected $message = '';

    /**
     *
     * @param array $options
     * @param string $message
     */
    public function __construct(array $options = array(), $message = ''){
        $this->setOptions($options);
        $this->setMessage($message);
    }

    /**
     *
     * @param mixed $value
     */
    public function __invoke($value){
        return $this->isValid($value);
    }

    /**
     * (non-PHPdoc)
     * @see SpecValidator\Validator.ValidatorInterface::check()
     */
    public function check($value){
        if( !$this->isValid($value) ){
            throw new ErrorsException($this->getErrors());
        }
    }

    /**
     *
     * @param string $method
     * @param array $args
     * @return ValidatorInterface
     */
    public static function __callstatic($method, $args){
        $message = array_shift($args);
        $options = array_shift($args);
        return PluginLoader::factory($method, $options ?: array(), $message);
    }

    /**
     *
     * @param string $method
     * @param array $args
     * @return ValidatorInterface
     */
    public function __call($method, $args){
        $message = array_shift($args);
        $options = array_shift($args);

        $isOr = preg_match('/^or/', $method);
        $method = $isOr ? preg_replace('/^or/', '', $method) : $method;

        $validator = PluginLoader::factory($method, $options ?: array(), $message);
        if( $isOr ){
            return $this->addOR($validator);
        }

        return $this->addAND($validator);
    }

    /**
     * (non-PHPdoc)
     * @see SpecValidator\Validator.ValidatorInterface::addOR()
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
     * @see SpecValidator\Validator.ValidatorInterface::addAND()
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
     * @see SpecValidator\Validator.ValidatorInterface::not()
     */
    public function not(){
        return new NotValidator($this);
    }

    /**
     * (non-PHPdoc)
     * @see SpecValidator\Validator.ValidatorInterface::optional()
     */
    public function optional(){
        return new OptionalValidator($this);
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
            array_unshift($args, $this);
        }else if ( $args instanceof ValidatorInterface ) {
            $args = array($this, $args);
        }
        return $args;
    }

    /**
     *
     * Enter description here ...
     * @param string $error
     */
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
     * @see SpecValidator\Validator.ValidatorInterface::getErrors()
     */
    public function getErrors(){
        return array_values($this->errors);
    }


    /**
     * (non-PHPdoc)
     * @see SpecValidator\Validator.ValidatorInterface::getOptions()
     */
    public function getOptions() {
        return $this->options;
    }

    /**
     * (non-PHPdoc)
     * @see SpecValidator\Validator.ValidatorInterface::getMessage()
     */
    public function getMessage() {
        return $this->message;
    }

    /**
     * (non-PHPdoc)
     * @see SpecValidator\Validator.ValidatorInterface::setOptions()
     */
    public function setOptions(array $options = array()) {
        $this->options = $options;
    }

    /**
     * (non-PHPdoc)
     * @see SpecValidator\Validator.ValidatorInterface::setMessage()
     */
    public function setMessage($message) {
        $this->message = $message;
    }

    /**
     *
     * Clear errors
     */
    public function clearErrors(){
        $this->errors = array();
    }

}