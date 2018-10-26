<?php

namespace Phacil\Json2Class\Traits;

trait Json2ClassTrait {

    private $json;

    public function setJsonFromFile($path)
    {
        if (is_file($path))
        {
            $data = file_get_contents($path);
            $this->json = json_decode($data);
        }
        return $this;
    }

    public function getJson()
    {
        return $this->json;
    }

    public function setJson($json)
    {
        $this->json = json_decode($json);
        return $this;
    }
   
}
