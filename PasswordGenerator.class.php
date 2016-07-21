<?php

/**
 * @author Sektor
 * @copyright 2013
 */

class PasswordGenerator{
    private $bUpperCase, $bLowerCase, $bNumbers, $bSpecChars;
    private $iPasswordLength;
    
    public function __construct($bUpperCase = true, $bLowerCase = true, $bNumbers = true, $bSpecChars = false, $iPasswordLength = 20){
        $this->bUpperCase      = $bUpperCase;
        $this->bLowerCase      = $bLowerCase;
        $this->bNumbers        = $bNumbers;
        $this->bSpecChars      = $bSpecChars;
        $this->iPasswordLength = $iPasswordLength;
    }
    
    public function GeneratePassword(){
        $password = "";
        $generateDone = false;
    
        if(!$this->bUpperCase && !$this->bLowerCase
                && !$this->bNumbers && !$this->bSpecChars)
            return $password;
    
        for($i = 0; $i < $this->iPasswordLength; $i++){
            do{
                $generateDone = false;
                switch(rand(0,4)){
                    case 0:
                        if($this->bUpperCase){
                            $password .= $this->GenerateUpperCase();
                            $generateDone = true;
                        }
                        break;
                    case 1:
                        if($this->bLowerCase){
                            $password .= $this->GenerateLowerCase();
                            $generateDone = true;
                        }
                        break;
                    case 2:
                        if($this->bNumbers){
                            $password .= $this->GenerateNumber();
                            $generateDone = true;
                        }
                        break;
                    case 3:
                        if($this->bSpecChars){
                            $password .= $this->GenerateSpecChar();
                            $generateDone = true;
                        }
                        break;
                }
            }
            while(!$generateDone);
        }
    
        return $password;
    }
    
    private function GenerateNumber(){
        return rand(0,9);
    }
    
    private function GenerateUpperCase(){
        $AZ = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        return substr($AZ,rand(0,strlen($AZ)-1),1);
    }
    
    private function GenerateLowerCase(){
        $az = "abcdefghijklmnopqrstuvwxyz";
        return substr($az,rand(0,strlen($az)-1),1);
    }
    
    private function GenerateSpecChar(){
        $chars = "!'#$%&\"()*+`-.{/:;<=>?@[]\\^_|}";
        return substr($chars,rand(0,strlen($chars)-1),1);
    }
}

?>