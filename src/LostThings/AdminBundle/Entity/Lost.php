<?php

namespace LostThings\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lost
 *
 * @ORM\Table(name="div_lost")
 * @ORM\Entity(repositoryClass="LostThings\AdminBundle\Entity\Repository\LostRepository")
 * @ORM\HasLifecycleCallbacks()
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
     * @ORM\Column(name="country_id", type="integer", nullable=true)
     */
    private $countryId;




    /**
     * @var integer
     *
     * @ORM\Column(name="city_id", type="integer", nullable=true)
     */
    private $cityId;


    /**
     * @var integer
     *
     * @ORM\Column(name="area_id", type="integer", nullable=true)
     */
    private $areaId;

    /**
     * @var integer
     *
     * @ORM\Column(name="street_id", type="integer", nullable=true)
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
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $userId;



    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", nullable=true)
     */
    private $status;



    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_lost", type="datetime", nullable=true)
     */
    private $dateLost;


    /**
     * @var string
     *
     * @ORM\Column(name="file_name", type="string", nullable=true)
     */
    private $fileName;



    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_find", type="datetime", nullable=true)
     */
    private $dateFind;



    /**
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="losts")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     */
    protected $country;


    /**
     * @ORM\ManyToOne(targetEntity="City", inversedBy="losts")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     */
    protected $city;


    /**
     * @ORM\ManyToOne(targetEntity="Area", inversedBy="losts")
     * @ORM\JoinColumn(name="area_id", referencedColumnName="id")
     */
    protected $area;


    /**
     * @ORM\ManyToOne(targetEntity="Street", inversedBy="losts")
     * @ORM\JoinColumn(name="street_id", referencedColumnName="id")
     */
    protected $street;


    /**
     * @ORM\ManyToOne(targetEntity="Thing", inversedBy="losts")
     * @ORM\JoinColumn(name="thing_id", referencedColumnName="id")
     */
    protected $thing;


    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="losts")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $username;


    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->dateLost = new \DateTime();
    }


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
     * Set description
     *
     * @param string $description
     * @return Lost
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
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

    /**
     * Set country
     *
     * @param \LostThings\AdminBundle\Entity\Country $country
     * @return Lost
     */
    public function setCountry(\LostThings\AdminBundle\Entity\Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \LostThings\AdminBundle\Entity\Country 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set city
     *
     * @param \LostThings\AdminBundle\Entity\City $city
     * @return Lost
     */
    public function setCity(\LostThings\AdminBundle\Entity\City $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \LostThings\AdminBundle\Entity\City 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set area
     *
     * @param \LostThings\AdminBundle\Entity\Area $area
     * @return Lost
     */
    public function setArea(\LostThings\AdminBundle\Entity\Area $area = null)
    {
        $this->area = $area;

        return $this;
    }

    /**
     * Get area
     *
     * @return \LostThings\AdminBundle\Entity\Area 
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * Set street
     *
     * @param \LostThings\AdminBundle\Entity\Street $street
     * @return Lost
     */
    public function setStreet(\LostThings\AdminBundle\Entity\Street $street = null)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return \LostThings\AdminBundle\Entity\Street 
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set thing
     *
     * @param \LostThings\AdminBundle\Entity\Thing $thing
     * @return Lost
     */
    public function setThing(\LostThings\AdminBundle\Entity\Thing $thing = null)
    {
        $this->thing = $thing;

        return $this;
    }

    /**
     * Get thing
     *
     * @return \LostThings\AdminBundle\Entity\Thing 
     */
    public function getThing()
    {
        return $this->thing;
    }

    /**
     * Set username
     *
     * @param \LostThings\AdminBundle\Entity\User $username
     * @return Lost
     */
    public function setUsername(\LostThings\AdminBundle\Entity\User $username = null)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return \LostThings\AdminBundle\Entity\User 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set fileName
     *
     * @param string $fileName
     * @return Lost
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string 
     */
    public function getFileName()
    {
        return $this->fileName;
    }
}
