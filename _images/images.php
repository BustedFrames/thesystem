<?php

require_once APP_ROOT."system/collections.php";

class Image extends Item{
        public $title;

        public function __construct($path){
            
            $key = basename($path);
            
            $home = str_replace($key,"",$path);

           parent::__construct($key,$home);
            
        }
        
        public function __destruct(){}
        
        public function url(){
            return str_replace(APP_ROOT,BASEURL,$this->path).$this->name;
        }
        
        public function img(){
            echo "<img src=\"{$this->url()}\" width=\"300\"/>";
        }
}

class Images extends Collection{
        
        public function __construct($path){
            parent::__construct($path);
        }
        
        public function __destruct(){}
        
        public function get_image(){
            $_ = array();
            
            $keys = parent::get_collection($this->path);
            
            foreach($keys as $key){
               
                $image = new Image($key,$this->path);
                
                $_[] = $image;
            }
            return $_;
        }
        
        public function add($image){
            $image->save();
        }
        

        
}
