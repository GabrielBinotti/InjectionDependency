<?php

require "Person.php";
require "JsonExporter.php";

$person = new Person;

$person->name   = "Gabriel Binotti";
$person->age    = 31;
$person->email  = "gabrielbinotti.dev@gmail.com";

$result = $person->export(new JsonExporter);

print_r($result);