<?php
namespace RuParser;

require __DIR__ . '/../../../vendor/autoload.php';

Class RuParser
{
    public function __construct($cfg){
        if(!empty($cfg['welcome'])){
            echo $this->welcome(); 
        } 
    }

    public function welcome(){
        echo 'Hello World';
    }
}        
?>