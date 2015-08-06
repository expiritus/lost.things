<?php

namespace LostThings\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Messages
 *
 * @ORM\Table(name="div_message")
 * @ORM\Entity(repositoryClass="LostThings\AdminBundle\Entity\Repository\MessageRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Message
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
     * @ORM\Column(name="send_user_id", type="integer")
     */
    private $sendUserId;

    /**
     * @var integer
     *
     * @ORM\Column(name="received_user_id", type="integer")
     */
    private $receivedUserId;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text")
     */
    private $message;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    /**
     * @var integer
     *
     * @ORM\Column(name="current_user_id", type="integer")
     */
    private $currentUser;


    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="messages")
     * @ORM\JoinColumn(name="send_user_id", referencedColumnName="id")
     */
    protected $username;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="message")
     * @ORM\JoinColumn(name="received_user_id", referencedColumnName="id")
     */
    protected $receivedUsername;


    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="currentUserMessages")
     * @ORM\JoinColumn(name="current_user_id", referencedColumnName="id")
     */
    protected $currentUsername;


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
     * Set sendUserId
     *
     * @param integer $sendUserId
     * @return Message
     */
    public function setSendUserId($sendUserId)
    {
        $this->sendUserId = $sendUserId;

        return $this;
    }

    /**
     * Get sendUserId
     *
     * @return integer 
     */
    public function getSendUserId()
    {
        return $this->sendUserId;
    }

    /**
     * Set receivedUserId
     *
     * @param integer $receivedUserId
     * @return Message
     */
    public function setReceivedUserId($receivedUserId)
    {
        $this->receivedUserId = $receivedUserId;

        return $this;
    }

    /**
     * Get receivedUserId
     *
     * @return integer 
     */
    public function getReceivedUserId()
    {
        return $this->receivedUserId;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return Message
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Message
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }


    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return Message
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
     * Set receivedUsername
     *
     * @param \LostThings\AdminBundle\Entity\User $receivedUsername
     * @return Message
     */
    public function setReceivedUsername(\LostThings\AdminBundle\Entity\User $receivedUsername = null)
    {
        $this->receivedUsername = $receivedUsername;

        return $this;
    }

    /**
     * Get receivedUsername
     *
     * @return \LostThings\AdminBundle\Entity\User 
     */
    public function getReceivedUsername()
    {
        return $this->receivedUsername;
    }

    /**
     * Set username
     *
     * @param \LostThings\AdminBundle\Entity\User $username
     * @return Message
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
     * Set currentUser
     *
     * @param integer $currentUser
     * @return Message
     */
    public function setCurrentUser($currentUser)
    {
        $this->currentUser = $currentUser;

        return $this;
    }

    /**
     * Get currentUser
     *
     * @return integer
     */
    public function getCurrentUser()
    {
        return $this->currentUser;
    }

    /**
     * Set currentUsername
     *
     * @param \LostThings\AdminBundle\Entity\User $currentUsername
     * @return Message
     */
    public function setCurrentUsername(\LostThings\AdminBundle\Entity\User $currentUsername = null)
    {
        $this->currentUsername = $currentUsername;

        return $this;
    }

    /**
     * Get currentUsername
     *
     * @return \LostThings\AdminBundle\Entity\User
     */
    public function getCurrentUsername()
    {
        return $this->currentUsername;
    }
}
