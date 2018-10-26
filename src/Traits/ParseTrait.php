<?php

namespace Phacil\Json2Class\Traits;

trait ParseTrait {
    
    use Json2ClassTrait;
    
    private function setConfigValores($object = null, $classAtual = null, $namespace = null)
    {
        $inflector = \ICanBoogie\Inflector::get();

        if(is_null($namespace)){
            $class = new \ReflectionClass(get_class($this)); 
            $namespace = $class->getNamespaceName();
        }      
              
        if (is_null($classAtual))
        {
            $classAtualCamelize = get_class($this);
        
            $obj = $this;
        } else
        {
            $classAtualCamelize = $namespace . '\\' . $inflector->camelize($classAtual);
        
            $obj = new $classAtualCamelize();
        }
        
        
        if (is_null($object))
        {
            $object = $this->json;
        }
        
        
        foreach ($object as $key => $value)
        {      
            $keyCamelize = $inflector->camelize($inflector->underscore($key));
            if (is_array($value))
            {

                $collection = [];
                
                if (
                        isset($value[0])
                        && (is_object($value[0]))
                    )
                {
                    foreach($value as $c => $d){
                        $collection[] = $this->setConfigValores($d, $key, $namespace);
                    }

                    $classAtualCamelizeCollection = $namespace ."\\" . $keyCamelize . 'Collection';

                    $collection_obj = new $classAtualCamelizeCollection($collection);
                    $metodo = 'set'. $keyCamelize . 'Collection';
                    call_user_func_array([$obj, $metodo], [$collection_obj]);
                }else{
                    $metodo = 'set'. $keyCamelize;
                    if(method_exists($obj, $metodo)){
                        call_user_func_array([$obj, $metodo], [$value]);
                    } else {
                        $obj->{$key} = $value;
                    }
                }
                                
            } else if (is_object($value))
            {

                $teste = $namespace ."\\" . $keyCamelize;
                
                
                if(class_exists($teste)){
                    $retorno = $this->setConfigValores($value, $key, $namespace);
                    $metodo = 'set'. $keyCamelize;
                    call_user_func_array([$obj, $metodo], [$retorno]);
                }else{
                    $metodo = 'set'. $keyCamelize;
                    if(method_exists($obj, $metodo)){
                        call_user_func_array([$obj, $metodo], [$value]);
                    } else {
                        $obj->{$key} = $value;
                    }
                }
                
            } else
            {

                $metodo = 'set'. $keyCamelize;
                if(method_exists($obj, $metodo)){
                    call_user_func_array([$obj, $metodo], [$value]);
                    } else {
                        $obj->{$key} = $value;
                    }
            }
        }

        return $obj;
    }
    
    public function parse()
    {
        return $this->setConfigValores();
    }
}
