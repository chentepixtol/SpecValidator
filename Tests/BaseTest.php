<?php

use SpecValidator\Validator\NullValidator;
use SpecValidator\Validator\EmptyValidator;
use SpecValidator\Validator\Nullable;
use SpecValidator\Validator\ValidatorRegistry;
use SpecValidator\Validator\ZendValidator;
use Symfony\Component\ClassLoader\UniversalClassLoader;
use SpecValidator\Validator\String;
use SpecValidator\Validator\Number;

require_once 'vendor/Symfony/Component/ClassLoader/UniversalClassLoader.php';

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    'SpecValidator' => 'src',
));
$loader->registerPrefix('Zend_', '/usr/share/php/library');
$loader->register();

/**
 *
 * @author chente
 *
 */
abstract class BaseTest extends PHPUnit_Framework_TestCase
{

    /**
     * (non-PHPdoc)
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    public function setUp()
    {
        ValidatorRegistry::registerFromArray(array(
            'int' => new ZendValidator('Int', "Valor invalido: %value%, se esperaba un entero"),
            'float' => new ZendValidator('Float', "Valor invalido: %value%, se esperaba un flotante"),
            'null'=> new NullValidator(),
            'empty' => new EmptyValidator(),
            'alpha' => new ZendValidator('Alpha', 'Solo Letras y se dio %value%'),
            'alpha_ws' => new ZendValidator('Alpha', 'Solo Letras y se dio %value%', array('allowWhiteSpace'=> true)),
            'alnum' => new ZendValidator('Alnum', 'Solo Alfanumerico y se dio %value%'),
            'alnum_ws' => new ZendValidator('Alnum', 'Solo Alfanumerico y se dio %value%', array('allowWhiteSpace'=> true)),
            'date' => new ZendValidator('Date', 'La fecha introducida %value% es incorrecta', array('format' => 'yyyy-MM-dd')),
        ));
    }
}

