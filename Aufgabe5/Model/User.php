<?php

namespace Model;

use JsonSerializable;

class User implements JsonSerializable
{
    private $username;
    private $firstname;
    private $lastname;
    private $coffeeOrTea;
    private $comment;
    private $layout;

    /**
     * Constructor creating the User Object
     * 
     * @param name - Name of User, Default-Value: null
     */
    function __construct($name = null)
    {
        $this->username = $name;
        $this->layout = "1";
        $this->coffeeOrTea ="0";
        $this->comment = "";
    }


    //--------------------
    // Getter
    //--------------------

    public function get_username(): string
    {
        return $this->username;
    }

    public function get_firstname(): string
    {
        return $this->firstname;
    }

    public function get_lastname(): string
    {
        return $this->lastname;
    }

    public function get_coffeeOrTea(): string
    {
        return $this->coffeeOrTea;
    }

    public function get_comment(): string
    {
        return $this->comment;
    }

    public function get_layout(): string
    {
        if($this->layout != null){
            return $this->layout;
        }
        return "1";
    }



    //--------------------
    // Setter
    //--------------------
    public function set_firstname($firstname): void
    {
        $this->firstname = $firstname;
    }

    public function set_lastname($lastname): void
    {
        $this->lastname = $lastname;
    }

    public function set_coffeeOrTea($coffeeOrTea): void
    {
        $this->coffeeOrTea = $coffeeOrTea;
    }

    public function set_comment($comment): void
    {
        $this->comment = $comment;
    }

    public function set_layout($layout): void
    {
        $this->layout = $layout;
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
