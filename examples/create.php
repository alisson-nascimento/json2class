<?php

require_once '../vendor/autoload.php';

use AlissonNascimento\Json2Class\Json2Class;

$json2Class = (new Json2Class())->setNamespace("Gonube\WatsonSdk\WatsonAssistant\Response\Message")
        ->setOutputFolder("../src/Response")
        ->setProjeto("MessageResponse")
        ->setJsonFromFile('../files/model.json');

//pr($json2Class->getJson());

$json2Class->generateClasses();