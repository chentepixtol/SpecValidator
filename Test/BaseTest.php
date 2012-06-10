<?php

namespace SpecValidator\Test;

use SpecValidator\Validator\NullValidator;
use SpecValidator\Validator\EmptyValidator;
use SpecValidator\Validator\Nullable;
use SpecValidator\ValidatorRegistry;
use SpecValidator\Validator\ZendValidator;
use SpecValidator\Validator\String;
use SpecValidator\Validator\Number;

/**
 *
 * @author chente
 *
 */
abstract class BaseTest extends \PHPUnit_Framework_TestCase
{

    /**
     * (non-PHPdoc)
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    public function setUp()
    {
        ValidatorRegistry::registerFromArray(array(
            'int' => new ZendValidator(array('validator' => 'Int'), "Valor invalido: %value%, se esperaba un entero"),
            'float' => new ZendValidator(array('validator' => 'Float'), "Valor invalido: %value%, se esperaba un flotante"),
            'null'=> new NullValidator(),
            'empty' => new EmptyValidator(),
            'alpha' => new ZendValidator(array('validator' => 'Alpha'), 'Solo Letras y se dio %value%'),
            'alpha_ws' => new ZendValidator(array('validator' => 'Alpha', 'allowWhiteSpace'=> true), 'Solo Letras y se dio %value%'),
            'alnum' => new ZendValidator(array('validator' => 'Alnum'), 'Solo Alfanumerico y se dio %value%'),
            'alnum_ws' => new ZendValidator(array('validator' => 'Alnum', 'allowWhiteSpace'=> true), 'Solo Alfanumerico y se dio %value%'),
            'date' => new ZendValidator(array('validator' => 'Date', array('format' => 'yyyy-MM-dd')), 'La fecha introducida %value% es incorrecta'),
        ));
    }
}

