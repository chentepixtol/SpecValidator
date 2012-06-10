<?php

namespace SpecValidator\Validator;

/**
 *
 * ValidatorInterface
 *
 * @package SpecValidator
 * @subpackage SpecValidator\Validator
 * @copyright (c) Vicente Mendoza <chentepixtol@gmail.com>
 * @author chentepixtol
 *
 */
interface ValidatorInterface
{

    /**
     * @param mixed $value
     * @return boolean
     */
    public function isValid($value);

    /**
     *
     * @param ValidatorInterface $validator
     * @return ValidatorInterface
     */
    public function addAND($validator);

    /**
     *
     * @param mixed $value
     * @throws \Exception
     */
    public function check($value);

    /**
     *
     * @param ValidatorInterface $validator
     * @return ValidatorInterface
     */
    public function addOR($validator);

    /**
     *
     * @return ValidatorInterface
     */
    public function not();

    /**
     *
     * @return ValidatorInterface
     */
    public function optional();



    /**
     *
     * @param string $message
     */
    public function setMessage($message);

    /**
     *
     * return string
     */
    public function getMessage();

    /**
     *
     * @param array $options
     */
    public function setOptions(array $options = array());

    /**
     *
     * @return array
     */
    public function getOptions();

    /**
     *
     * @return array
     */
    public function getErrors();

}