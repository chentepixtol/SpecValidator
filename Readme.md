SpecValidator
---------------

Es una herramienta que te permite hacer validaciones de manera facil y sencilla.

Validadores Disponibles
------------------------

ArrayAssocValidator
ArrayValidator
EmptyValidator
NullValidator
ZendValidator

Ejemplos

ZendValidator
-------------

Se pueden usar los validadores definidos por el Zend Framerwork (http://framework.zend.com/manual/en/zend.validate.html)

    $int = new ZendValidator('Int', "Valor invalido: %value%, se esperaba un entero");
    $int->isValid(5);    // true
    $int->isValid('5');  // true 

ArrayAssocValidator
-------------------

        $validator = new ArrayAssocValidator(array(
            'username' => new ZendValidator('Alpha', "Valor invalido: %value%, se esperaban caracteres"),
            'password' => new ZendValidator('Alnum', "Valor invalido: %value%, se esperaban caracteres alfanumericos"),
        ));
        
        $user = array(
            'username' => 'chentepixtol',
            'password' => '123'
        );
        
        $validator->isValid($user); // true
     
        
ArrayValidator
-------------------

        $validator = new ArrayValidator(new ZendValidator('Alpha', "Valor invalido: %value%, se esperaban caracteres"));
        
        $users = array(
            'chentepixtol',
            'vicentemmor',
        );
        
        $validator->isValid($users); // true
        
        $users = array(
            'chentepixtol',
            123,
        );
        
        $validator->isValid($users); // false


Specification
--------------

Se utiliza el patron Specification, con lo cual podemos hacer facilmente condiciones booleanas.

$validatorInt = ...
$validatorAlpha = ...
$validatorNull = ...

$validatorIntOrAlpha = $validatorInt->addOR($validatorAlpha);
$validatorNotNull = $validatorNull->not();



NESTED
------

        $validator = new ArrayAssocValidator(array(
            'username' => new ZendValidator('Alpha', "Valor invalido: %value%, se esperaban caracteres"),
            'password' => new ZendValidator('Alnum', "Valor invalido: %value%, se esperaban caracteres alfanumericos"),
            'address' => new ArrayAssocValidator(array(
                'street' => new ZendValidator('Alpha', "Valor invalido: %value%, se esperaban caracteres"),
                'zip' => new ZendValidator('Alnum', "Valor invalido: %value%, se esperaban caracteres alfanumericos"),
            ),
        ));
        ));

