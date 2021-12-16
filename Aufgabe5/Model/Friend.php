<?php

namespace Model;

use JsonSerializable;

class Friend implements JsonSerializable
{
    private $username;
    private $status;

    /**
     * Constructor creating the User Object
     * 
     * @param name - Name of User, Default-Value: null
     */
    function __construct($name = null)
    {
        $this->username = $name;
    }



    //--------------------
    // Getter
    //--------------------

    public function accept_friend()
    {
        $this->status = "accepted";
    }

    public function dismiss_friend()
    {
        $this->status = "dismissed";
    }



    //--------------------
    // Getter
    //--------------------

    public function get_username(): string
    {
        return $this->username;
    }

    public function get_status()
    {
        return $this->status;
    }



    //--------------------
    // Json Converting
    //--------------------

    /**
     * Serialisez this User object into a formatted json string
     */
    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }

    /**
     * Moves Content from Json $data to a newly generated User object
     * 
     * @param data - Json packet
     * 
     * @return user - a new User Object
     */
    public static function fromJson($data)
    {
        $friend = new Friend();
        foreach ($data as $key => $value) {
            $friend->{$key} = $value;
        }

        return $friend;
    }
}
