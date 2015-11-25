<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class DataUserFacebook
{
    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     */
    protected $profilName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $pictureProfilUrl;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\LikeFacebook", cascade={"persist"})
     */
    private $likes;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->likes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return DataUserFacebook
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * Set profilName
     *
     * @param string $profilName
     * @return DataUserFacebook
     */
    public function setProfilName($profilName)
    {
        $this->profilName = $profilName;

        return $this;
    }

    /**
     * Get profilName
     *
     * @return string 
     */
    public function getProfilName()
    {
        return $this->profilName;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return DataUserFacebook
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set pictureProfilUrl
     *
     * @param string $pictureProfilUrl
     * @return DataUserFacebook
     */
    public function setPictureProfilUrl($pictureProfilUrl)
    {
        $this->pictureProfilUrl = $pictureProfilUrl;

        return $this;
    }

    /**
     * Get pictureProfilUrl
     *
     * @return string 
     */
    public function getPictureProfilUrl()
    {
        return $this->pictureProfilUrl;
    }

    /**
     * Add likes
     *
     * @param \AppBundle\Entity\LikeFacebook $likes
     * @return DataUserFacebook
     */
    public function addLike(\AppBundle\Entity\LikeFacebook $likes)
    {
        $this->likes[] = $likes;

        return $this;
    }

    /**
     * Remove likes
     *
     * @param \AppBundle\Entity\LikeFacebook $likes
     */
    public function removeLike(\AppBundle\Entity\LikeFacebook $likes)
    {
        $this->likes->removeElement($likes);
    }

    /**
     * Get likes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLikes()
    {
        return $this->likes;
    }
}
