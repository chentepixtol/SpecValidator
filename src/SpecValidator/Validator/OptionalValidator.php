<?php

namespace SpecValidator\Validator;

/**
 *
 * OrValidator
 *
 * @package SpecValidator
 * @subpackage SpecValidator\Validator
 * @copyright (c) Vicente Mendoza <chentepixtol@gmail.com>
 * @author chentepixtol
 *
 */
class OptionalValidator extends OrValidator
{

    /**
     *
     * @var ValidatorInterface
     */
    public static $emptyValidator = null;

    /**
     *
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        if( null == self::$emptyValidator ){
            self::$emptyValidator = new EmptyValidator();
        }

        parent::__construct(array(self::$emptyValidator, $validator));
    }

}