<?php

namespace Phacil\Json2Class;

class Json2Class {
    
    use \Phacil\Json2Class\Traits\GenerateTrait;
    
    const PONTO_VIRGULA = ";";
    const PULA_LINHA = "\n";
    const PULA_LINHA_DUPLO = "\n\n";
    const TAB = "    ";
    const TAB_DUPLO = "        ";
    
    private $namespace;
    private $outputFolder;
    private $projeto;

    public function getNamespace() {
        return $this->namespace;
    }

    public function getOutputFolder() {
        return $this->outputFolder;
    }

    public function getProjeto() {
        return $this->projeto;
    }

    public function setProjeto($projeto) {
        $this->projeto = $projeto;
        return $this;
    }

    public function setNamespace($namespace) {
        $this->namespace = $namespace;
        return $this;
    }

    public function setOutputFolder($outputFolder) {
        $this->outputFolder = $outputFolder;
        return $this;
    }
}
