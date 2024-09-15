<?php

class AccessControl
{
    
    static public function logIn($user, $passWord)
    {
        
    }
    
    static public function logOut()
    {
        
    }
    
    static public function logOn()
    {
        
    }
    
    static public function checkCredentials($user, $passWord)
    {
        if ($user) {
            # code...
        }
    }
    
    static private function message($error, $msg)
    {
        return [
            'error' => $error,
            'msg' => $msg,
        ];
    }
}