<?php

class Profile extends Entity{
    
    public $name;
    public $display_name;

    
    public function __construct($name=null, $path=null){
        parent::__construct($name, $path);
        $this->name = $name;
    }
    
}



class Profiles extends Collection{
    
    public function get_profiles(){
        $users = parent::get_collection();
        $_ = array();
        foreach($users as $user){
            $_[] = new Profile($user, $this->path);
        }
        
        return $_;
    }
    
    public function create_profile($name){
        if($this->profile_exists($name)){
            $user = new Profile($name);
            return $this->load($this->path);
        }
    }
    
    public function profile_exists($name){
        
        if(is_object($name)){
            $profile= $profile->name;
        }
        
        $profile_dir = $this->path.$name;
        
        return (file_exists($profile_dir) && is_dir($profile_dir));
        
    }

    
    public function delete_1($name){
        if(!$this->profile_exists($name)){
            return false;
        }
        else{
            removeDirectory($this->dir.$name);
        }
          
    }

    
}