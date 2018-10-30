<?php

namespace Phacil\Json2Class\Traits;

trait Json2ClassTrait {

    private $_json_data_object;
    
    public function __construct($_json_data_object = []) 
    {
        
        $data = $_json_data_object;
        
        if (is_array($_json_data_object)){
            $data = json_decode(json_encode($_json_data_object));
        }else if(is_string($_json_data_object)){
            $data = json_decode($_json_data_object);
        }
        
        $this->setJsonDataObject($data);
    }

    public function setJsonFromFile($path)
    {
        if (is_file($path))
        {
            $data = file_get_contents($path);
            $this->_json_data_object = json_decode($data);
        }
        return $this;
    }

    public function getJsonDataObject() 
    {
        return $this->_json_data_object;
    }

    public function setJsonDataObject($_json_data_object) 
    {
        $this->_json_data_object = $_json_data_object;
        return $this;
    }
   
}
