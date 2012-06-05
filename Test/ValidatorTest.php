<?php

namespace SpecValidator\Test;

/**
 *
 * @author chente
 *
 */
use SpecValidator\Validator\ZendValidator;
use SpecValidator\Validator\OptionalValidator;
use SpecValidator\Validator\ValidatorRegistry;
use SpecValidator\Validator\EmptyValidator;
use SpecValidator\Validator\Nullable;
use SpecValidator\Validator\ArrayValidator;
use SpecValidator\Validator\ZendValidateAdapter;
use SpecValidator\Validator\ArrayAssocValidator;
use SpecValidator\Validator\InArrayValidator;

/**
 *
 * @author chente
 *
 */
class ValidatorTest extends BaseTest
{

    /**
     *
     * @test
     */
    public function arrayTest()
    {
        $validator = new ArrayValidator(ValidatorRegistry::get('int'));
        $validatorFloat = new ArrayValidator(ValidatorRegistry::get('float'));

        //valid
        $this->assertTrue($validatorFloat->isValid(array(4.3, 4.5, 43.3)));

        //valid
        $this->assertTrue($validator->isValid(array('43', 4, 43)));
        //invalid
        $this->assertFalse($validator->isValid(array('65', 'abc', 56)));
        $this->assertEquals(array('Valor invalido: abc, se esperaba un entero'), $validator->getErrors());

        $validatorIntOrFloat = new ArrayValidator(ValidatorRegistry::get('int')->addOR(ValidatorRegistry::get('float')));

        //valid
        $this->assertTrue($validatorIntOrFloat->isValid(array(4, 4.3, 43.7)));
        $this->assertFalse($validatorIntOrFloat->isValid(array('abc', 'de', 5, 5.1)));
    }

    /**
     *
     * @test
     */
    public function nullableTest()
    {
        $nullable = ValidatorRegistry::get('null');
        $intValidator = ValidatorRegistry::get('int');
        $validator = $nullable->addOR($intValidator);

        //valid
        $this->assertTrue($validator->isValid('43'));
        $this->assertTrue($validator->isValid(43));
        $this->assertTrue($validator->isValid(null));

        //invalid
        $this->assertFalse($validator->isValid('string'));

        $arrayValidator = $nullable->addOR(new ArrayValidator($intValidator));

        //valid
        $this->assertTrue($arrayValidator->isValid(array(4,5)));
        $this->assertTrue($arrayValidator->isValid(array()));
        $this->assertTrue($arrayValidator->isValid(null));
    }

    /**
     *
     * @test
     */
    public function multipleORs()
    {
        $get = ValidatorRegistry::getter();

        $validator = $get('int')->addOR($get('empty'), $get('alpha'));
        $this->assertTrue($validator->isValid(4));
        $this->assertTrue($validator->isValid('34'));
        $this->assertTrue($validator->isValid(null));
        $this->assertTrue($validator->isValid('string'));
    }

    /**
     *
     * @test
     */
    public function multipleANDs()
    {
        $get = ValidatorRegistry::getter();

        $validator = $get('int')->not()->addAND($get('empty')->not(), $get('alpha'));
        $this->assertEquals(3, $validator->count());
        $this->assertFalse($validator->isEmpty());
        $this->assertFalse($validator->isValid(4));
        $this->assertFalse($validator->isValid('34'));
        $this->assertFalse($validator->isValid(null));
        $this->assertTrue($validator->isValid('string'));
    }

    /**
     *
     * @test
     */
    public function emptyTest()
    {
        $empty = ValidatorRegistry::get('empty');
        $validator = $empty->addOR(ValidatorRegistry::get('int'));

        //valid
        $this->assertTrue($validator->isValid('43'));
        $this->assertTrue($validator->isValid(43));
        $this->assertTrue($validator->isValid(null));
        $this->assertTrue($validator->isValid(''));
        $this->assertTrue($validator->isValid(0));

        $this->assertFalse($validator->isValid('string'));
    }

    /**
     *
     * @test
     */
    public function arrayAssoc()
    {
        $alpha = ValidatorRegistry::get('alpha');
        $alnum = ValidatorRegistry::get('alnum');

        $user = array(
            'username' => 'chentepixtol',
        );

        $validator = new ArrayAssocValidator(array(
            'username' => $alpha,
            'password' => $alnum,
        ));

        $this->assertFalse($validator->isValid($user));

        $user['password'] = '123';
        $this->assertTrue($validator->isValid($user));
    }

    /**
     *
     * @test
     */
    public function complexTest()
    {
        $get = ValidatorRegistry::getter();
        $this->assertTrue( ValidatorRegistry::getter() === ValidatorRegistry::getter() );

        $alpha = $get('alpha_ws');
        $alphaNum = $get('alnum_ws');
        $int = $get('int');
        $empty = $get('empty');

        $validator = new ArrayAssocValidator(array(
            'name' => $alpha,
            'description' => $empty->addOR($alpha),
            'text' => $alphaNum,
            'myObject' => new ArrayAssocValidator(array(
                'myObjectId' => $int,
                'mySystems' => new ArrayValidator($alpha),
            )),
        ));

        $result = $validator->isValid(array(
            'name' => 'Vicente',
            //'description' => 'descripcion de muchas cosas',
            'text' => 'texto yeah ',
            'myObject' => array(
                'myObjectId' => '455',
                'mySystems' => array('linux', 'windows')
            )
        ));

        $this->assertTrue($result);
    }

    /**
     *
     * @test
     */
    public function not(){

        $validator = ValidatorRegistry::get('null');
        $this->assertTrue($validator->isValid(null));
        $this->assertFalse($validator->isValid('string'));

        $notNullValidator = $validator->not();
        $this->assertFalse($notNullValidator->isValid(null));
        $this->assertTrue($notNullValidator->isValid('string'));
    }


    /**
     *
     * @test
     */
    public function notExists(){
        $validator = ValidatorRegistry::get('not_exists');
        $this->assertNull($validator);
    }

    /**
     *
     * @test
     */
    public function optional()
    {
        $int = ValidatorRegistry::get('int');
        $optionalInt = new OptionalValidator($int);

        $this->assertTrue($optionalInt->isValid('5'));
        $this->assertTrue($optionalInt->isValid(5));
        $this->assertTrue($optionalInt->isValid(null));
        $this->assertFalse($optionalInt->isValid('abc'));
    }

    /**
     *
     * @test
     */
    public function inArray()
    {
        $sos = array('linux', 'windows', 'mac');
        $validator = new InArrayValidator($sos, 'System invalid');

        $this->assertTrue($validator->isValid('linux'));
        $this->assertTrue($validator->isValid('windows'));
        $this->assertTrue($validator->isValid('mac'));

        $this->assertFalse($validator->isValid('amiga'));
        $this->assertFalse($validator->isValid('freebsd'));
    }


}

