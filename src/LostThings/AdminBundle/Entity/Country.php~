<?php

namespace LostThings\AdminBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Country
 *
 * @ORM\Table(name="div_country")
 * @ORM\Entity
 */
class Country
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
     * @ORM\Column(name="country", type="string", length=255)
     */
    private $country;


    /**
     * @ORM\OneToMany(targetEntity="City", mappedBy="country")
     */
    protected $cities;


    /**
     * @ORM\OneToMany(targetEntity="Find", mappedBy="country")
     */
    protected $finds;


    public function __toString(){
        return $this->country ? $this->country : "";
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
     * Set country
     *
     * @param string $country
     * @return Country
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string 
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
        $this->cities = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add cities
     *
     * @param \LostThings\AdminBundle\Entity\City $cities
     * @return Country
     */
    public function addCity(\LostThings\AdminBundle\Entity\City $cities)
    {
        $this->cities[] = $cities;

        return $this;
    }

    /**
     * Remove cities
     *
     * @param \LostThings\AdminBundle\Entity\City $cities
     */
    public function removeCity(\LostThings\AdminBundle\Entity\City $cities)
    {
        $this->cities->removeElement($cities);
    }

    /**
     * Get cities
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCities()
    {
        return $this->cities;
    }

    /**
     * Add finds
     *
     * @param \LostThings\AdminBundle\Entity\Find $finds
     * @return Country
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
