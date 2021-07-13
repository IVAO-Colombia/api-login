<?php


namespace IvaoSocialite;


use ArrayAccess;

class User implements \Laravel\Socialite\Contracts\User, ArrayAccess
{
    private $id;
    private $firstName;
    private $lastName;

    /** @var array */
    private $raw;

    public function __construct(array $raw)
    {
        $this->id = $raw["vid"];
        $this->firstName = $raw["firstname"];
        $this->lastName = $raw["lastname"];
        $this->raw = [
            "vid" => intval($raw["vid"]),
            "firstname" => $raw["firstname"],
            "lastname" => $raw["lastname"],
            "rating" => $raw["rating"],
            "ratingatc" => $raw["ratingatc"],
            "ratingpilot" => $raw["ratingpilot"],
            "division" => $raw["division"],
            "country" => $raw["country"],
            "staff" => $raw["staff"] ? explode(":", $raw["staff"]) : [],
            "va_staff_ids" => $raw["va_staff_ids"] ? explode(":", $raw["va_staff_ids"]) : [],
            "va_member_ids" => $raw["va_member_ids"] ? explode(":", $raw["va_member_ids"]) : [],
        ];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNickname()
    {
        return null;
    }

    public function getName()
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function getEmail()
    {
        return null;
    }

    public function getAvatar()
    {
        return null;
    }

    public function getRaw() {
        return $this->raw;
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->raw);
    }

    public function offsetGet($offset)
    {
        return $this->raw[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->raw[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->raw[$offset]);
    }
}