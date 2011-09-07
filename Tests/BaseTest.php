<?php

use Schema\Validator\ZendValidateAdapter;
use Symfony\Component\ClassLoader\UniversalClassLoader;
use Schema\Validator\String;
use Schema\Validator\Number;

require_once 'vendor/Symfony/Component/ClassLoader/UniversalClassLoader.php';

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
	'Schema'     => 'SchemaValidator/',
));
$loader->registerPrefix('Zend_', '/usr/share/php/library');
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

