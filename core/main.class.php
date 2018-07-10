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

    private function parseINI($file){
        $arr = parse_ini_file($file); 
        return; 
    }
    
    public function welcome(){
        echo 'Hello World';
    }
}        
?>