<?php

require_once '../vendor/autoload.php';

$response = new AlissonNascimento\Json2Class\Response\Message\MessageResponse();
$response->setJsonFromFile('../files/data2.json');
$response->parse();

pr($response);