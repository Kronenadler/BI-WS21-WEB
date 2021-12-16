<?php

namespace Utils;

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
    }
    public function saveUser($username)
    {
    }
    public function loadFriends()
    {
    }
    public function friendRequest($friend)
    {
    }
    public function friendAccept($friend)
    {
    }
    public function friendDismiss($friend)
    {
    }
    public function friendRemove($friend)
    {
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
