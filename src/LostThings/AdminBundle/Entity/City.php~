<?php

namespace LostThings\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * City
 *
 * @ORM\Table(name="div_city")
 * @ORM\Entity(repositoryClass="LostThings\AdminBundle\Entity\Repository\CityRepository")
 */
class City
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
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var integer
     *
     * @ORM\Column(name="country_id", type="integer")
     */
    private $countryId;


    /**
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="cities")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     */
    protected $country;


    /**
     * @ORM\OneToMany(targetEntity="Area", mappedBy="city")
     */
    protected $areas;


    /**
     * @ORM\OneToMany(targetEntity="Find", mappedBy="city")
     */
    protected $finds;


    public function __toString(){
        return $this->city ? $this->city : "";
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
     * Set city
     *
     * @param string $city
     * @return City
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set countryId
     *
     * @param integer $countryId
     * @return City
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
     * Set country
     *
     * @param \LostThings\AdminBundle\Entity\Country $country
     * @return City
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
     * Constructor
     */
    public function __construct()
    {
        $this->areas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add areas
     *
     * @param \LostThings\AdminBundle\Entity\Area $areas
     * @return City
     */
    public function addArea(\LostThings\AdminBundle\Entity\Area $areas)
    {
        $this->areas[] = $areas;

        return $this;
    }

    /**
     * Remove areas
     *
     * @param \LostThings\AdminBundle\Entity\Area $areas
     */
    public function removeArea(\LostThings\AdminBundle\Entity\Area $areas)
    {
        $this->areas->removeElement($areas);
    }

    /**
     * Get areas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAreas()
    {
        return $this->areas;
    }

    /**
     * Add finds
     *
     * @param \LostThings\AdminBundle\Entity\Find $finds
     * @return City
     */
    public function addFind(\LostThings\AdminBundle\Entity\Find $finds)
    {
        $this->finds[] = $finds;

        return $this;
    }

    /**
     * Remove finds
     *
     * @param \LostThings\AdminBundle\Entity\Find $finds
     */
    public function removeFind(\LostThings\AdminBundle\Entity\Find $finds)
    {
        $this->finds->removeElement($finds);
    }

    /**
     * Get finds
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFinds()
    {
        return $this->finds;
    }
}
