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
                $_SESSION["user"] = $username;
                return true;
            }

        } catch (\Exception $e) {
            error_log($e);
        }
        return false;
    }

    public function loadUser($username) {
        try {
            $ergebnis = HttpClient::get($this->base . '/' . $this->id . '/' . 'user' . '/' . $username, $_SESSION['chat_token']);
            $user = User::fromJson($ergebnis);
            return $user;
        } catch(\Exception $e) {
            error_log($e);
        }
        return false;
    }

    public function saveUser($user) {
        try {
            $ergebnis = HttpClient::post($this->base . '/' . $this->id . '/' . 'user' . '/' , $user, $_SESSION['chat_token']);
            return true;
        } catch(\Exception $e) {
            error_log($e);
        }
        return false;
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
            

           return HttpClient::post($this->base . '/' . $this->id . "/friend",  array("username" => $friend), $_SESSION["chat_token"]);
        } catch(\Exception $e) {
            echo "Error...";
        }
    }
    public function friendAccept($friend){
    try {
        return HttpClient::put($this->base . '/' . $this->id . "/friend" . "/" . $friend,
            array("status" => "accepted"),
            $_SESSION["chat_token"]);
      //  echo "Accepted...";
    } catch(\Exception $e) {
        echo "Error3...$e";
    }
    }

    public function friendDismiss($friend)
    {try {
        return HttpClient::put($this->base . '/' . $this->id . "/friend" . "/" . $friend,
            array("status" => "dismissed"),  $_SESSION["chat_token"]);
        
    } catch(\Exception $e) {
        echo "Error1...".$e;
    }
    }
    public function friendRemove($friend)
    {try {
        HttpClient::delete($this->base . '/' . $this->id . "/friend" . "/" . $friend, $_SESSION["chat_token"]);
        echo "Removed...";
    } catch(\Exception $e) {
        echo "Error.2..".$e;
    }
    }
    public function userExists($username)
    {
        try {

            $response = HttpClient::get($this->base . '/' . $this->id . "/user" . "/" . $username);

            if ($response == false) {
                // User not found
                return false;
            } else {
                // User found
                return true;
            }
        } catch (\Exception $e) {
            error_log($e);
        }
        return false;
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