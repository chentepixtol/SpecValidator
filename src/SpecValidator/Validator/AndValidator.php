<?php

namespace SpecValidator\Validator;

/**
 *
 * AndValidator
 *
 * @package SpecValidator
 * @subpackage SpecValidator\Validator
 * @copyright (c) Vicente Mendoza <chentepixtol@gmail.com>
 * @author chentepixtol
 *
 */
class AndValidator extends CompositeValidator
{

    /**
     * (non-PHPdoc)
     * @see SpecValidator\Validator.ValidatorInterface::isValid()
     */
    public function isValid($value)
    {
        $this->clearErrors();
        $isValid = true;
        foreach( $this->getValidators() as $validator ){
            if( $validator instanceof ValidatorInterface && !$validator->isValid($value) ){
                $this->addError($validator->getErrors());
                $isValid = false;
            }
        }
        return $isValid;
    }

}