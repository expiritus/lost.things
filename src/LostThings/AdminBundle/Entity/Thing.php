<?php

namespace LostThings\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Thing
 *
 * @ORM\Table(name="div_thing")
 * @ORM\Entity(repositoryClass="LostThings\AdminBundle\Entity\Repository\ThingRepository")
 */
class Thing
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
     * @ORM\Column(name="name_thing", type="string", length=255)
     */
    private $nameThing;

    /**
     * @var boolean
     *
     * @ORM\Column(name="base_thing", type="boolean")
     */
    private $baseThing;


    /**
     * @ORM\OneToMany(targetEntity="Find", mappedBy="thing")
     */
    protected $finds;

    /**
     * @ORM\OneToMany(targetEntity="Lost", mappedBy="thing")
     */
    protected $losts;



    public function __toString(){
        return $this->nameThing ? $this->nameThing : "";
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
     * Set nameThing
     *
     * @param string $nameThing
     * @return Thing
     */
    public function setNameThing($nameThing)
    {
        $this->nameThing = $nameThing;

        return $this;
    }

    /**
     * Get nameThing
     *
     * @return string 
     */
    public function getNameThing()
    {
        return $this->nameThing;
    }

    /**
     * Set baseThing
     *
     * @param boolean $baseThing
     * @return Thing
     */
    public function setBaseThing($baseThing)
    {
        $this->baseThing = $baseThing;

        return $this;
    }

    /**
     * Get baseThing
     *
     * @return boolean 
     */
    public function getBaseThing()
    {
        return $this->baseThing;
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
     * @return Thing
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
     * Add losts
     *
     * @param \LostThings\AdminBundle\Entity\Lost $losts
     * @return Thing
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
