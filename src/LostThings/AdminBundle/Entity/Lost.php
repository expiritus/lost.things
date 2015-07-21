<?php

namespace LostThings\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lost
 *
 * @ORM\Table(name="div_lost")
 * @ORM\Entity(repositoryClass="LostThings\AdminBundle\Entity\Repository\LostRepository")
 */
class Lost
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="country_id", type="integer")
     */
    private $countryId;

    /**
     * @var integer
     *
     * @ORM\Column(name="city_id", type="integer")
     */
    private $cityId;


    /**
     * @var integer
     *
     * @ORM\Column(name="area_id", type="integer")
     */
    private $areaId;


    /**
     * @var integer
     *
     * @ORM\Column(name="street_id", type="integer")
     */
    private $streetId;



    /**
     * @var integer
     *
     * @ORM\Column(name="thing_id", type="integer")
     */
    private $thingId;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;



    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_lost", type="datetime")
     */
    private $dateLost;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_find", type="datetime")
     */
    private $dateFind;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set countryId
     *
     * @param integer $countryId
     * @return Lost
     */
    public function setCountryId($countryId)
    {
        $this->countryId = $countryId;

        return $this;
    }

    /**
     * Get countryId
     *
     * @return integer 
     */
    public function getCountryId()
    {
        return $this->countryId;
    }

    /**
     * Set cityId
     *
     * @param integer $cityId
     * @return Lost
     */
    public function setCityId($cityId)
    {
        $this->cityId = $cityId;

        return $this;
    }

    /**
     * Get cityId
     *
     * @return integer 
     */
    public function getCityId()
    {
        return $this->cityId;
    }

    /**
     * Set areaId
     *
     * @param integer $areaId
     * @return Lost
     */
    public function setAreaId($areaId)
    {
        $this->areaId = $areaId;

        return $this;
    }

    /**
     * Get areaId
     *
     * @return integer 
     */
    public function getAreaId()
    {
        return $this->areaId;
    }

    /**
     * Set streetId
     *
     * @param integer $streetId
     * @return Lost
     */
    public function setStreetId($streetId)
    {
        $this->streetId = $streetId;

        return $this;
    }

    /**
     * Get streetId
     *
     * @return integer 
     */
    public function getStreetId()
    {
        return $this->streetId;
    }

    /**
     * Set thingId
     *
     * @param integer $thingId
     * @return Lost
     */
    public function setThingId($thingId)
    {
        $this->thingId = $thingId;

        return $this;
    }

    /**
     * Get thingId
     *
     * @return integer 
     */
    public function getThingId()
    {
        return $this->thingId;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     * @return Lost
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return Lost
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set dateLost
     *
     * @param \DateTime $dateLost
     * @return Lost
     */
    public function setDateLost($dateLost)
    {
        $this->dateLost = $dateLost;

        return $this;
    }

    /**
     * Get dateLost
     *
     * @return \DateTime 
     */
    public function getDateLost()
    {
        return $this->dateLost;
    }

    /**
     * Set dateFind
     *
     * @param \DateTime $dateFind
     * @return Lost
     */
    public function setDateFind($dateFind)
    {
        $this->dateFind = $dateFind;

        return $this;
    }

    /**
     * Get dateFind
     *
     * @return \DateTime 
     */
    public function getDateFind()
    {
        return $this->dateFind;
    }
}
