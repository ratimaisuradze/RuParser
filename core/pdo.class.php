<?php
namespace RuParser;  
use \PDO; 
Class myDB 
{
    private $HOST = 'localhost';
    private $USER = 'root';
    private $PASS = 'th1gam3r1@';
    private $DBNAME = 'ratBot'; 
    
    // ბაზასთან დაკავშირებული ცვლადი
    private $dbh;
    // ბოლოს დაჭერილი შეცდომა
    private $error; 
    
    private $stmt; 

    public function __construct(){
        //Set DNS 
        $dns = 'mysql:host=' . $this->HOST . ';dbname=' . $this->DBNAME;  
        $options = array(  
            PDO::ATTR_PERSISTENT => true,  
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        // ბაზასთან დაკავშირება PDO ექსთენშენით.  
        try{
            $this->dbh = new PDO($dns, $this->USER, $this->PASS); 
        }
        // შეცდომის დაჭერა 
        catch(PDOException $e){
            $this->error = $e->getMessage(); 
        }
    }

    public function query($query){
        $this->stmt = $this->dbh->prepare($query); 
    }
}
?>