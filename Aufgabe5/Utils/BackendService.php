<?php

namespace Utils;

use Model\User;

class BackendService
{

    private $base; // Chat Server URL
    private $id; // Chat Server ID

    function __construct($base, $id)
    {
        $this->base = $base;
        $this->id = $id;
    }



    //--------------------
    // BackendService Functions
    //--------------------

    public function login($username, $password)
    {
        try {
            $data["username"] = $username;
            $data["password"] = $password;

            $response = HttpClient::post($this->base . '/' . $this->id . "/login", $data);

            if ($response === true) {
                // User not found
                return false;
            } else {
                $_SESSION["chat_token"] = $response->token;
                return true;
            }
        } catch (\Exception $e) {
            error_log($e);
        }
        return false;
    }

    public function register($username, $password)
    {
        try {
            $data["username"] = $username;
            $data["password"] = $password;

            $response = HttpClient::post($this->base . '/' . $this->id . "/register", $data);

            if ($response === true) {
                // Sth went wrong
                return false;
            } else {
                $_SESSION["chat_token"] = $response->token;
                return true;
            }

        } catch (\Exception $e) {
            error_log($e);
        }
        return false;
    }

    public function loadUser($username)
    {
        try {
            $data["username"] = "Tom";
            
            $response = HttpClient::get($this->base . '/' . $this->id . "/user", $data);
            echo $response;
            return User::fromJson($username);
        } catch (\Exception $e) {
            error_log($e);
        }
    }
    
    public function saveUser($username)
    {
    }
    public function loadFriends()
    {
        {   try {
            $data = $_SESSION["chat_token"];
            $result = HttpClient::get($this->base . '/' . $this->id . "/friend", $data);
            var_dump($result);
            return $result;
        } catch(\Exception $e) {
            echo "Error...";
        }
    }}
    public function friendRequest($friend)
    {
        try {
           return HttpClient::post($this->base . '/' . $this->id . "/friend", $friend, $_SESSION["chat_token"]);
        } catch(\Exception $e) {
            echo "Err...";
        }
    }
    public function friendAccept($friend)
    {try {
        return HttpClient::put($this->base . '/' . $this->id . "/friend" . "/" . $friend,
            array("status" => "accepted"),  $_SESSION["chat_token"]);
        
    } catch(\Exception $e) {
        echo "Error...";
    }
    }
    public function friendDismiss($friend)
    {try {
        return HttpClient::put($this->base . '/' . $this->id . "/friend" . "/" . $friend,
            array("status" => "dismissed"),  $_SESSION["chat_token"]);
        
    } catch(\Exception $e) {
        echo "Error...";
    }
    }
    public function friendRemove($friend)
    {try {
        Utils\HttpClient::delete($this->base . '/' . $this->id . "/friend" . "/" . $friend, $_SESSION["chat_token"]);
        echo "Removed...";
    } catch(\Exception $e) {
        echo "Error...";
    }
    }
    public function userExists($username)
    {
    }
    public function getUnread()
    {
    }

    //
    // For missing functions see API Documentation in ReadMe!!!!
    //



    //--------------------
    // Test Functions
    //--------------------

    public function test()
    {
        try {
            return HttpClient::get($this->base . '/test.json');
        } catch (\Exception $e) {
            error_log($e);
        }
        return false;
    }
}