<?php

namespace SpecValidator\Validator;

/**
 *
 * ArrayValidator
 *
 * @package SpecValidator
 * @subpackage SpecValidator\Validator
 * @copyright (c) Vicente Mendoza <chentepixtol@gmail.com>
 * @author chentepixtol
 *
 */
class ArrayValidator extends CompositeValidator
{
    /**
     * (non-PHPdoc)
     * @see SpecValidator\Validator.ValidatorInterface::isValid()
     */
    public function isValid($value)
    {
        $this->clearErrors();

        if( !is_array($value) ){
            $this->addError("El valor propocionado no es un array");
            return false;
        }

        $validator = $this->getOne();
        $isValid = true;
        foreach ($value as $val){
            if ( !$validator->isValid($val) ){
                $this->addError($validator->getErrors());
                $isValid = false;
            }
        }

        return $isValid;
    }


}