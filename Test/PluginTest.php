<?php

namespace SpecValidator\Test;

/**
 *
 * @author chente
 *
 */
use SpecValidator\Validator\ValidatorInterface;
use SpecValidator\Validator\Validator;
use SpecValidator\PluginLoader;
use SpecValidator\Validator\ZendValidator;
use SpecValidator\Validator\OptionalValidator;
use SpecValidator\ValidatorRegistry;
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
class PluginTest extends BaseTest
{


    /**
     * @test
     * @dataProvider getPluginNames
     */
    public function exists($name){
        $this->assertTrue(PluginLoader::exists($name));
    }

    /**
     * @test
     * @dataProvider getPluginNames
     */
    public function factory($name, $args){
        $validator = PluginLoader::factory($name, $args);
        $this->assertTrue($validator instanceof ValidatorInterface);
    }

    /**
     * @test
     * @dataProvider getInexistsPluginNames
     * @expectedException \SpecValidator\Exception
     */
    public function notexists($name, $args){
        PluginLoader::factory($name, $args);
    }

    /**
     * @test
     * @dataProvider getPluginNames
     */
    public function callstatic($plugin){
       $validator = call_user_func("\\SpecValidator\\Validator\\Validator::{$plugin}");
       $this->assertTrue($validator instanceof ValidatorInterface);


    }

    /**
     * @test
     */
    public function intByCallStatic(){
        $int = Validator::int("mensaje de error");
        $this->assertTrue($int->isValid(1));
        $this->assertTrue($int->isValid('1'));
        $this->assertFalse($int->isValid("not int"));
        $this->assertEquals(array("mensaje de error"), $int->getErrors());
    }

    /**
     * @test
     */
    public function chained(){
        $chain = Validator::int("tiene que ser entero")
            ->lessThan('tiene que ser menor que 56', array('max' => 56));

        $this->assertTrue($chain->isValid(5));
        $this->assertTrue($chain->isValid(50));

        $this->assertFalse($chain->isValid(500));
        $this->assertFalse($chain->isValid(750));
    }

    /**
     * @test
     */
    public function floatOrInt(){
        $validator = Validator::int("Debe de ser entero")
            ->orFloat("O debe de ser flotante");
        $this->assertTrue($validator->isValid(2));
        $this->assertTrue($validator->isValid('2'));
        $this->assertTrue($validator->isValid(2.3));
        $this->assertFalse($validator->isValid("String"));
    }

    /**
     *
     * @return array
     */
    public function getPluginNames(){
        return array(
            array('arrayAssoc', array()),
            array('array', array()),
            array('empty', array()),
            array('inArray', array()),
            array('null', array()),
            array('int', array()),
            array('float', array()),
            array('alnum', array()),
            array('emailAddress', array()),
        );
    }

    /**
     *
     * @return array
     */
    public function getInexistsPluginNames(){
        return array(
            array('and', array()),
            array('composite', array()),
            array('not', array()),
            array('optional', array()),
            array('or', array()),
            array('zend', array()),
        );
    }

}

