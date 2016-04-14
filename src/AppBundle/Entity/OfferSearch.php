<?php

namespace AppBundle\Entity;

class OfferSearch
{
    /**
     * @var int
     */
    private $age;

    /**
     * @var string
     */
    private $address;

    /**
     * @var int
     */
    private $activity;

    /**
     * @var float
     */
    private $latitude;

    /**
     * @var float
     */
    private $longitude;

    /**
     * @var bool
     */
    private $male;

    /**
     * @var bool
     */
    private $female;

    /**
     * @var float
     */
    private $distance;

    /**
     * @return float
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * @param float $distance
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;
    }

    /**
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param int $age
     */
    public function setAge($age)
    {
        $this->age = $age;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return int
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * @param int $activity
     */
    public function setActivity($activity)
    {
        $this->activity = $activity;
    }

    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @return boolean
     */
    public function isMale()
    {
        return $this->male;
    }

    /**
     * @param boolean $male
     */
    public function setMale($male)
    {
        $this->male = $male;
    }

    /**
     * @return boolean
     */
    public function isFemale()
    {
        return $this->female;
    }

    /**
     * @param boolean $female
     */
    public function setFemale($female)
    {
        $this->female = $female;
    }
}
