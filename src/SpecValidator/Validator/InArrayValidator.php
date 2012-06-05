<?php

namespace SpecValidator\Validator;

/**
 *
 * InArrayValidator
 *
 * @package SpecValidator
 * @subpackage SpecValidator\Validator
 * @copyright (c) Vicente Mendoza <chentepixtol@gmail.com>
 * @author chentepixtol
 *
 */
class InArrayValidator extends ZendValidator
{

    /**
     *
     *
     * @param array $haystack
     * @param string $message
     * @param array $options
     */
    public function __construct($haystack, $message = null, array $options = array()){
        $options['haystack'] = $haystack;
        parent::__construct('InArray', $message, $options);
    }

}