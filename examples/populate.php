<?php

require_once '../vendor/autoload.php';

$response = new Phacil\Json2Class\Response\AssitantResponse();
$response->setJsonFromFile('../files/data2.json');
$response->parse();

pr($response);