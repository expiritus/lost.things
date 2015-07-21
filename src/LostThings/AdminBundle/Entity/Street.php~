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
     * @ORM\Column(name="area_id", type="integer")
     */
    private $areaId;


    /**
     * @ORM\ManyToOne(targetEntity="Area", inversedBy="streets")
     * @ORM\JoinColumn(name="area_id", referencedColumnName="id")
     */
    protected $area;


    /**
     * @ORM\OneToMany(targetEntity="Find", mappedBy="street")
     */
    protected $finds;



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
     * Set areaId
     *
     * @param integer $areaId
     * @return Street
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
     * Set area
     *
     * @param \LostThings\AdminBundle\Entity\Area $area
     * @return Street
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
}
