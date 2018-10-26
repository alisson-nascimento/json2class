<?php

require_once '../vendor/autoload.php';

$response = new Phacil\Json2Class\Response\AsssitantResponse();
$response->setJsonFromFile('../files/data.json');
$response->parse();

pr($response);