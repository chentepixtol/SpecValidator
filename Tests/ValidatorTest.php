<?php

/**
 *
 * @author chente
 *
 */
use Schema\Validator\ArrayValidator;
use Schema\Validator\ZendValidateAdapter;
use Schema\Validator\ArrayAssoc;
class ValidatorTest extends BaseTest
{

	/**
	 *
	 * @test
	 */
	public function objectTest(){

		$alpha = new ZendValidateAdapter('Alpha', 'Solo Letras y se dio %value%', array('allowWhiteSpace'=> true));
		$alphaNum = new ZendValidateAdapter('Alnum', 'Solo Alfanumerico y se dio %value%', array('allowWhiteSpace'=> true));
		$int = new ZendValidateAdapter('Int', 'El campo es Solo Numerico y se dio %value%');


		$validator = new ArrayAssoc(array(
			'name' => $alpha,
			'description' => $alpha,
			'text' => $alphaNum,
			'myObject' => new ArrayAssoc(array(
				'myObjectId' => $int,
				'mySystems' => new ArrayValidator($alpha),
			)),
		));

		$result = $validator->isValid(array(
			'name' => 'Vicente',
			'description' => 'descripcion de muchas cosas',
			'text' => 'texto yeah ',
			'myObject' => array(
				'myObjectId' => '455',
				'mySystems' => array('linux', 'windows')
			)
		));

		$this->assertTrue($result);

	}


}

