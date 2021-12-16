<?php

namespace Model;

use JsonSerializable;

class User implements JsonSerializable
{
    private $username;

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

    public function get_username(): string
    {
        return $this->username;
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
        $user = new User();
        foreach ($data as $key => $value) {
            $user->{$key} = $value;
        }

        return $user;
    }
}
