<?php
/**
 * Created by PhpStorm.
 * User: michail
 * Date: 13.07.15
 * Time: 9:51
 */

namespace LostThings\AdminBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="div_user")
 * @ORM\Entity
 */
class User extends BaseUser {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @ORM\OneToMany(targetEntity="Find", mappedBy="username")
     */
    protected $finds;
    



    /**
     * @ORM\OneToMany(targetEntity="Lost", mappedBy="username")
     */
    protected $losts;

    public function __construct()
    {
        parent::__construct();
        // your own logic

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
     * Add finds
     *
     * @param \LostThings\AdminBundle\Entity\Find $finds
     * @return User
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
     * @return User
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
