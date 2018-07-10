<?php
namespace RuParser;

require __DIR__ . '/../../../vendor/autoload.php';

use PHPHtmlParser\Dom;

Class RuParser
{
    public function __construct($cfg){
        if(!empty($cfg['welcome'])){
            echo $this->welcome(); 
        } 
    }
    
    public function welcome(){
        //echo 'Hello World';
    }

    private function parseINI($file){
        $arr = parse_ini_file($file); 
        return; 
    }

    public function getHtmlByPage($domain, $link, $page){
        switch($domain){
            case 'KinoGo':
            $dom = new Dom;
            $dom->load($link . '/page/' . $page . '/');     
            $links = $dom->find('.zagolovki strong a'); 
            $lnk = []; 
            foreach($links as $link){
                array_push($lnk, $link->href); 
            }
            return $lnk; 
            break;
        }
    }

    public function getContent($domObject){

    }

    public function saveContent($array){

    }
}        
?>