<?php
require_once "messages.php";

class User extends Entity{
    
    public $name;
    public $display_name;
    public $password;
    public $path;
    public $files;
    public $mailbox;
    public $profiles;
    
    public function __construct($name=null, $path=null){
        parent::__construct($name, $path);
        $this->files = new Files($this->path,"files");
        $this->profiles = new Profiles($this->path, "profiles");
    }
    
    public function login(){
        @session_start();
        $_SESSION['username'] = $this->name;
    }
    
    public function logout(){
        session_destroy();
    }
    public function set_password($password){
        $this->password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
    }
    public function validate($password){
        
        return password_verify($password, $this->password);
    }
    public function has_profile($type){
        return in_array($type, $this->profiles->get_collection());
    }
}


class Users extends Collection{
    
    public function get_users(){
        $users = parent::get_collection();
        $_ = array();
        foreach($users as $user){
            $_[] = new User($user, $this->path);
        }
        
        return $_;
    }
    
    public function create_user($name){
        if($this->user_exists($name)){
            $user = new User($name);
            return $this->load($this->path);
        }
    }
    
    public function user_exists($username){
        
        if(is_object($username)){
            $username= $username->username;
        }
        
        $user_dir = $this->path.$username;
        
        return (file_exists($user_dir) && is_dir($user_dir));
        
    }

    
    public function delete_1($username){
        if(!$this->user_exists($username)){
            return false;
        }
        else{
            removeDirectory($this->dir.$username);
        }
          
    }

    
}