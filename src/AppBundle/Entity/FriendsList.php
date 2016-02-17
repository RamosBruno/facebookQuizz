<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FriendsList
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class FriendsList
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
     * @ORM\Column(name="userId", type="integer")
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="friendProfilName", type="string", length=100)
     */
    private $friendProfilName;

    /**
     * @var string
     *
     * @ORM\Column(name="friendPictureProfilUrl", type="string", length=255)
     */
    private $friendPictureProfilUrl;


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
     * Set userId
     *
     * @param integer $userId
     * @return FriendsList
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
     * Set friendProfilName
     *
     * @param string $friendProfilName
     * @return FriendsList
     */
    public function setFriendProfilName($friendProfilName)
    {
        $this->friendProfilName = $friendProfilName;

        return $this;
    }

    /**
     * Get friendProfilName
     *
     * @return string 
     */
    public function getFriendProfilName()
    {
        return $this->friendProfilName;
    }

    /**
     * Set friendPictureProfilUrl
     *
     * @param string $friendPictureProfilUrl
     * @return FriendsList
     */
    public function setFriendPictureProfilUrl($friendPictureProfilUrl)
    {
        $this->friendPictureProfilUrl = $friendPictureProfilUrl;

        return $this;
    }

    /**
     * Get friendPictureProfilUrl
     *
     * @return string 
     */
    public function getFriendPictureProfilUrl()
    {
        return $this->friendPictureProfilUrl;
    }
}
