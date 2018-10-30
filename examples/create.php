<?php

require_once '../vendor/autoload.php';

use Phacil\Json2Class\Json2Class;

$json2Class = (new Json2Class())->setNamespace("Phacil\Json2Class\Response")
        ->setOutputFolder("../src/Response")
        ->setProjeto("AssitantResponse")
        ->setJsonFromFile('../files/model.json');

//pr($json2Class->getJson());

$json2Class->generateClasses();