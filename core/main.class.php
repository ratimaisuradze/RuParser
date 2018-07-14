<?php
namespace RuParser;

require __DIR__ . '/../../../vendor/autoload.php';
require __DIR__ . '/pdo.class.php'; 

use PHPHtmlParser\Dom;
use \Curl\MultiCurl;
use RuParser\myDB as DB;  

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

    public function ParsePage($htmlContent){
        $parse = []; 
        $dom = new Dom; 
        $a = $dom->load($htmlContent); 
        return [
            'title' => $dom->find('title')->innerHTML,
            'description' =>  $dom->find('meta')[1]->getAttribute('content'),
            'image' => $dom->find('.fullimg div img')[0]->getAttribute('src'), 
            'content' => $dom->find("span[itemprop='description']")->innerHTML
        ]; 
    }

    public function MultiCurlRequest($links){

        $multi_curl = new MultiCurl; 
        
        // Callback Data Before Send multi_curl Request
        $multi_curl->beforeSend(function ($instance)  {
        });
        
        // CallBack After Success multi_curl Request
        $multi_curl->success(function ($instance){
            $domHtml = $instance->response;
            // $Result-ს ენიჭება მასივი [title, description, image, content] 
            $result = $this->ParsePage($domHtml); 
            // შევინახოთ ბაზაში მოცემული მასივი
            $this->saveInDB($result); 
        });

        // Error Log
        $multi_curl->error(function ($instance){
            //$bot->lastComment = $instance->errorMessage;         
        });

        foreach($links as $link){
            $multi_curl->addGet($link);            
        }

        $multi_curl->start();
    }

    public function saveInDB(array $res){
        $db = new DB;
        $sql = 'INSERT INTO `ContentList`(`title`, `description`, `image`, `content`) VALUES (:title, :description, :image, :content)'; 
        // Statement PDO::prepare [განცხადების მოზადება]
        $db->query($sql); 
            
        $db->bind(':title', $res['title']); 
        $db->bind(':description', $res['description']); 
        $db->bind(':image', $res['image']);
        $db->bind(':content', $res['content']); 
        
        $db->execute();


    }
}        
?>