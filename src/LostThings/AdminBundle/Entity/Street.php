<?php

namespace LostThings\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Street
 *
 * @ORM\Table(name="div_street")
 * @ORM\Entity(repositoryClass="LostThings\AdminBundle\Entity\Repository\StreetRepository")
 */
class Street
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
     * @ORM\Column(name="street", type="string", length=255)
     */
    private $street;


    /**
     * @var integer
     *
     * @ORM\Column(name="city_id", type="integer", nullable=true)
     */
    private $cityId;



    /**
     * @ORM\ManyToOne(targetEntity="City", inversedBy="streets")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     */
    protected $city;


    /**
     * @ORM\OneToMany(targetEntity="Find", mappedBy="street")
     */
    protected $finds;

    /**
     * @ORM\OneToMany(targetEntity="Lost", mappedBy="street")
     */
    protected $losts;



    public function __toString(){
        return $this->street ? $this->street : "";
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
     * Set street
     *
     * @param string $street
     * @return Street
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string 
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->finds = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add finds
     *
     * @param \LostThings\AdminBundle\Entity\Find $finds
     * @return Street
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

    /**
     * Set cityId
     *
     * @param integer $cityId
     * @return Street
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
     * @return Street
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
     * Add losts
     *
     * @param \LostThings\AdminBundle\Entity\Lost $losts
     * @return Street
     */
    public function addLost(\LostThings\AdminBundle\Entity\Lost $losts)
    {
        $this->losts[] = $losts;

        return $this;
    }

    /**
     * Remove losts
     *
     * @param \LostThings\AdminBundle\Entity\Lost $losts
     */
    public function removeLost(\LostThings\AdminBundle\Entity\Lost $losts)
    {
        $this->losts->removeElement($losts);
    }

    /**
     * Get losts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLosts()
    {
        return $this->losts;
    }
}
