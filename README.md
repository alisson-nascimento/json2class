# Json2Class

JSON parse to Classes

## Installation

    composer require alisson-nascimento/json2class
    
## Example 1: Create Classes .php

    use AlissonNascimento\Json2Class\Json2Class;

    $json2Class = (new Json2Class())->setNamespace("AlissonNascimento\Json2Class\Response\Message")
        ->setOutputFolder("../src/Response")
        ->setProjeto("MessageResponse")
        ->setJsonFromFile('../files/model.json');
    $json2Class->generateClasses();
   
MessageResponse class will already be able to be instantiated directly by a json

## Example 2: Set Parse Trait

    class MessageResponse
    {
        use \AlissonNascimento\Json2Class\Traits\ParseTrait;
    }

## Example 3: Instantiate Classes .php

    $response = new AlissonNascimento\Json2Class\Response\MessageResponse();
    $response->setJsonFromFile('../files/data2.json');
    $response->parse();