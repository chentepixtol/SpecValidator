<?php

namespace SpecValidator\Validator;

/**
 *
 * Exception
 *
 * @package SpecValidator
 * @subpackage SpecValidator\Validator
 * @copyright (c) Vicente Mendoza <chentepixtol@gmail.com>
 * @author chentepixtol
 *
 */
class ErrorsException extends \Exception
{

    /**
     *
     * @var array
     */
    private $errors = array();

    /**
     *
     * @param array $errors
     */
    public function __construct(array $errors){
        $this->errors = $errors;
    }

    /**
     *
     * @return array
     */
    public function getErrors(){
        return $this->errors;
    }

}