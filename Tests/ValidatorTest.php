<?php

/**
 *
 * @author chente
 *
 */
use Schema\Validator\EmptyValidator;
use Schema\Validator\Nullable;
use Schema\Validator\ArrayValidator;
use Schema\Validator\ZendValidateAdapter;
use Schema\Validator\ArrayAssoc;
class ValidatorTest extends BaseTest
{

	/**
	 *
	 * @test
	 */
	public function arrayTest()
	{
		$validator = new ArrayValidator(new ZendValidateAdapter('Int', "Valor invalido: %value%, se esperaba un entero"));
		$validatorFloat = new ArrayValidator(new ZendValidateAdapter('Float', "Valor invalido: %value%, se esperaba un flotante"));

		//valid
		$this->assertTrue($validator->isValid(array('43', 4, 43)));
		//invalid
		$this->assertFalse($validator->isValid(array('65', 'abc', 56)));
		$this->assertEquals(array('Valor invalido: abc, se esperaba un entero'), $validator->getErrors());

		$validatorIntAndFloat = $validator->addOR($validatorFloat);

		//valid
		$this->assertTrue($validatorIntAndFloat->isValid(array('3.4', 4.3, 43)));
		//invalid

		$this->assertFalse($validatorIntAndFloat->isValid(array('abc', 'de')));
	}

	/**
	 *
	 * @test
	 */
	public function nullableTest()
	{
		$nullable = new  Nullable();
		$intValidator = new ZendValidateAdapter('Int', "Valor invalido: %value%, se esperaba un entero");
		$validator = $nullable->addOR($intValidator);

		//valid
		$this->assertTrue($validator->isValid('43'));
		$this->assertTrue($validator->isValid(43));
		$this->assertTrue($validator->isValid(null));

		$this->assertFalse($validator->isValid('string'));

		$arrayValidator = $nullable->addOR(new ArrayValidator($intValidator));
		$this->assertTrue($arrayValidator->isValid(array(4,5)));
		$this->assertTrue($arrayValidator->isValid(array()));
		$this->assertTrue($arrayValidator->isValid(null));
	}

	/**
	 *
	 * @test
	 */
	public function emptyTest()
	{
		$empty = new  EmptyValidator();
		$validator = $empty->addOR(new ZendValidateAdapter('Int', "Valor invalido: %value%, se esperaba un entero"));

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
	public function complexTest()
	{
		$alpha = new ZendValidateAdapter('Alpha', 'Solo Letras y se dio %value%', array('allowWhiteSpace'=> true));
		$alphaNum = new ZendValidateAdapter('Alnum', 'Solo Alfanumerico y se dio %value%', array('allowWhiteSpace'=> true));
		$int = new ZendValidateAdapter('Int', 'El campo es Solo Numerico y se dio %value%');
		$empty = new EmptyValidator();

		$validator = new ArrayAssoc(array(
			'name' => $alpha,
			'description' => $empty->addOR($alpha),
			'text' => $alphaNum,
			'myObject' => new ArrayAssoc(array(
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


}

