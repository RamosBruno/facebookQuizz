<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Win
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
     * @ORM\Column(name="quizz", type="integer")
     */
    private $quizz;

    /**
     * @var string
     *
     * @ORM\Column(name="dataUserFacebook", type="bigint")
     */
    private $dataUserFacebook;


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
     * Set quizz
     *
     * @param integer $quizz
     * @return Win
     */
    public function setQuizz($quizz)
    {
        $this->quizz = $quizz;

        return $this;
    }

    /**
     * Get quizz
     *
     * @return integer
     */
    public function getQuizz()
    {
        return $this->quizz;
    }

    /**
     * Set dataUserFacebook
     *
     * @param integer $dataUserFacebook
     * @return Win
     */
    public function setDataUserFacebook($dataUserFacebook)
    {
        $this->dataUserFacebook = $dataUserFacebook;

        return $this;
    }

    /**
     * Get dataUserFacebook
     *
     * @return integer
     */
    public function getDataUserFacebook()
    {
        return $this->dataUserFacebook;
    }
}
