<?php

namespace Phacil\Json2Class\Traits;
use ICanBoogie\Inflector;

trait GenerateTrait {
    
    use Json2ClassTrait;

    private function __createClassWrite($class, $attrs) {

        $inflector = \ICanBoogie\Inflector::get();

        $filename = $this->outputFolder . DIRECTORY_SEPARATOR . $inflector->camelize($class) . '.php';

        $file = fopen($filename, "w");
        fwrite($file, null);
        fclose($file);

        $file = fopen($filename, "a");

        fwrite($file, "<?php " . self::PULA_LINHA);
        fwrite($file, "namespace " . $this->namespace . self::PONTO_VIRGULA);
        fwrite($file, self::PULA_LINHA_DUPLO);
        fwrite($file, "class " . $inflector->camelize($class) . '{');
        fwrite($file, self::PULA_LINHA_DUPLO);
        if ($class == $this->projeto) {
            fwrite($file, self::TAB . "use \Phacil\Json2Class\Traits\ParseTrait" . self::PONTO_VIRGULA);
            fwrite($file, self::PULA_LINHA_DUPLO);
        }
        foreach ($attrs as $attr) {
            fwrite($file, self::TAB . "private \$" . $attr . self::PONTO_VIRGULA);
            fwrite($file, self::PULA_LINHA);
        }
        fwrite($file, self::PULA_LINHA);
        foreach ($attrs as $attr) {
            fwrite($file, self::TAB . "public function get" . $inflector->camelize($attr)
                    . "(){");
            fwrite($file, self::PULA_LINHA);
            fwrite($file, self::TAB_DUPLO . "return \$this->" . $attr . self::PONTO_VIRGULA);
            fwrite($file, self::PULA_LINHA);
            fwrite($file, self::TAB . '}');
            fwrite($file, self::PULA_LINHA_DUPLO);
            
            preg_match('/^[A-Z]/', $attr, $output_array);
            
            $attr_class = null;
            if(count($output_array) > 0){
                $attr_class = $attr . ' ';
            }

            fwrite($file, self::TAB . "public function set" . $inflector->camelize($attr)
                    . "($attr_class\$" . $attr . "){");
            fwrite($file, self::PULA_LINHA);
            fwrite($file, self::TAB_DUPLO . "\$this->" . $attr . " = \$" . $attr . self::PONTO_VIRGULA);
            fwrite($file, self::PULA_LINHA);
            fwrite($file, self::TAB_DUPLO . "return \$this" . self::PONTO_VIRGULA);
            fwrite($file, self::PULA_LINHA);
            fwrite($file, self::TAB . '}');
            fwrite($file, self::PULA_LINHA_DUPLO);
        }
        fwrite($file, self::PULA_LINHA);
        fwrite($file, "}");

        fclose($file);

        unset($file);
    }

    private function __createCollectionWrite($class) {

        $inflector = \ICanBoogie\Inflector::get();

        $collection = $inflector->camelize($class) . "Collection";

        $filename = $this->outputFolder . DIRECTORY_SEPARATOR . $collection . '.php';

        $file = fopen($filename, "w");
        fwrite($file, null);
        fclose($file);

        $file = fopen($filename, "a");

        fwrite($file, "<?php " . self::PULA_LINHA);
        fwrite($file, "namespace " . $this->namespace . self::PONTO_VIRGULA);
        fwrite($file, self::PULA_LINHA_DUPLO);
        fwrite($file, "use  Phacil\\Common\\AbstractClass\\AbstractCollection" . self::PONTO_VIRGULA);
        fwrite($file, self::PULA_LINHA_DUPLO);
        fwrite($file, "class " . $collection . ' extends AbstractCollection {');
        fwrite($file, self::PULA_LINHA_DUPLO);

        fwrite($file, self::TAB . "protected \$type = \\" . $this->namespace . "\\" . $inflector->camelize($class) . "::class" . self::PONTO_VIRGULA);

        fwrite($file, self::PULA_LINHA);
        fwrite($file, "}");

        fclose($file);


        unset($file);
    }

    public function setConfig($object, $classAtual = null, $classes = []) {
        $inflector = Inflector::get();

        if (!isset($classes[$classAtual])) {
            $classes['classes'][$classAtual] = [];
        }

        foreach ($object as $key => $value) {
            $keyCamelize = $inflector->camelize($inflector->underscore($key));

            if (is_array($value)) {

                if (
                        isset($value[0]) && (is_object($value[0]))
                ) {
                    $classes['classes'][$classAtual][] = $keyCamelize . 'Collection';
                    $classes['collections'][] = $keyCamelize;
                    $classes = $this->setConfig($value[0], $keyCamelize, $classes);
                } else {
                    $classes['classes'][$classAtual][] = $key;
                }
            } else if (is_object($value)) {
                $classes['classes'][$classAtual][] = $keyCamelize;
                $classes = $this->setConfig($value, $keyCamelize, $classes);
            } else {
                $classes['classes'][$classAtual][] = $key;
            }
        }
        pr($classAtual);
        return $classes;
    }

    public function generateClasses() {

        $config = $this->setConfig($this->json, $this->projeto);

        if (!file_exists($this->outputFolder)) 
        {
            mkdir($this->outputFolder, 0777, true);
        }

        foreach ($config['classes'] as $class => $attr) 
        {
            $this->__createClassWrite($class, $attr);
        }

        foreach ($config['collections'] as $collection) 
        {
            $this->__createCollectionWrite($collection);
        }
    }

}
