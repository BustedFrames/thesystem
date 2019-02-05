<?php
require_once "entities.php";
require_once "users.php";

class System{
    
    public $users;
    private $admin;
    public $user;
    public $profile_types;
    
    public function __construct($path){
        
        if(strpos($path, $_SERVER['DOCUMENT_ROOT'])===false){
            die("bad config.");
        }
        
        $path = rtrim($path,"/")."/";
        // validate path as a valid system root
        if(!file_exists($path)){
            // can specify alternate paths
            // deal with it then.
        }
        
        define("SYSTEM_ROOT",$path);
        define ("ENTITIES_ROOT", $path."_entities/");
        
        if(!file_exists(ENTITIES_ROOT)){
            mkdir(ENTITIES_ROOT);
        }
        
    }
    
    public function is_admin(){
        if(!empty($this->admin))
            return $this->admin->key == $this->user->key;
        
        return false;
        
    }
    
    public function login_user($username,$password){
        // validate input!
        
        if(!$this->users->user_exists($username)){
            die("do a bad user thing");
        }
        
        $user = new User($username,$this->users->path);
        
        if($user->validate($password)){
            @session_start();
            $_SESSION['username'] = $username;
            return true;
        }
        
        
        return false;
    }
    
    
    public function is_logged_in_user($username){
        if(!empty($_SESSION['username'])){
            if($this->users->user_exists($_SESSION['username'])){
                $this->user = new User($_SESSION['username'], $this->users->path);
            }
        }
        return $username==$_SESSION['username'];
    }
    
    
    // establish a session username using PHP sessions.
    public function establish_session(){
         
        if(!empty($_SESSION['username'])){
    
            if($this->users->user_exists($_SESSION['username'])){
                
                // set current user for objects
                $this->user = new User($_SESSION['username'], $this->users->path);
        
            }
        }
    }
    
    // over ride on object levels
    public function system_slug($str){
        
        return str_replace(" ","-",strtolower($str));

    }
    
    public function is_valid_profile_type($type){
        return in_array($type,$this->profile_types);
    }
    
    public function __destruct(){}
    
    
}