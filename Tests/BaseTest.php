<?php

use Symfony\Component\ClassLoader\UniversalClassLoader;

require_once 'vendor/Symfony/Component/ClassLoader/UniversalClassLoader.php';

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
	'Schema'     => 'SchemaValidator/',
));
$loader->register();


/**
 *
 * @author chente
 *
 */
class BaseTest extends PHPUnit_Framework_TestCase
{
	/**
	 *
	 * @test
	 */
	public function main(){
		$this->assertTrue(true);
	}

}

