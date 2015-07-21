<?php

namespace LostThings\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Area
 *
 * @ORM\Table(name="div_area")
 * @ORM\Entity(repositoryClass="LostThings\AdminBundle\Entity\Repository\AreaRepository")
 */
class Area
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
     * @ORM\Column(name="area", type="string", length=255)
     */
    private $area;


    /**
     * @var integer
     *
     * @ORM\Column(name="city_id", type="integer")
     */
    private $cityId;


    /**
     * @ORM\ManyToOne(targetEntity="City", inversedBy="areas")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     */
    protected $city;


    /**
     * @ORM\OneToMany(targetEntity="Street", mappedBy="area")
     */
    protected $streets;


    /**
     * @ORM\OneToMany(targetEntity="Find", mappedBy="area")
     */
    protected $finds;



    public function __toString(){
        return $this->area ? $this->area : "";
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
     * Set area
     *
     * @param string $area
     * @return Area
     */
    public function setArea($area)
    {
        $this->area = $area;

        return $this;
    }

    /**
     * Get area
     *
     * @return string 
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * Set cityId
     *
     * @param integer $cityId
     * @return Area
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
     * Set city
     *
     * @param \LostThings\AdminBundle\Entity\City $city
     * @return Area
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
     * Constructor
     */
    public function __construct()
    {
        $this->streets = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add streets
     *
     * @param \LostThings\AdminBundle\Entity\Street $streets
     * @return Area
     */
    public function addStreet(\LostThings\AdminBundle\Entity\Street $streets)
    {
        $this->streets[] = $streets;

        return $this;
    }

    /**
     * Remove streets
     *
     * @param \LostThings\AdminBundle\Entity\Street $streets
     */
    public function removeStreet(\LostThings\AdminBundle\Entity\Street $streets)
    {
        $this->streets->removeElement($streets);
    }

    /**
     * Get streets
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStreets()
    {
        return $this->streets;
    }

    /**
     * Add finds
     *
     * @param \LostThings\AdminBundle\Entity\Find $finds
     * @return Area
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
