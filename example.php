
<?php

$array = array(
	'name' => 'nombre del reporte',
	'description' => 'descripcion del reporte',
	'blocks' => array(
		array(
		 'title' => "Titulo",
          "description" => "descripcion del bloque",
          "params" => array(
               "dateStart" => "2011-08-01"
          ),
        ),
	),
);

$json = json_encode($array);

echo $json;

$object = json_decode($json, true);
echo "<br/>";
echo "<pre>";
print_r($object);
