<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Quizz
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    protected $gains;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    protected $numberOfWinner;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $dateStart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $dateEnd;

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
     * Set description
     *
     * @param string $description
     * @return Quizz
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set gains
     *
     * @param string $gains
     * @return Quizz
     */
    public function setGains($gains)
    {
        $this->gains = $gains;

        return $this;
    }

    /**
     * Get gains
     *
     * @return string 
     */
    public function getGains()
    {
        return $this->gains;
    }

    /**
     * Set numberOfWinner
     *
     * @param integer $numberOfWinner
     * @return Quizz
     */
    public function setNumberOfWinner($numberOfWinner)
    {
        $this->numberOfWinner = $numberOfWinner;

        return $this;
    }

    /**
     * Get numberOfWinner
     *
     * @return integer 
     */
    public function getNumberOfWinner()
    {
        return $this->numberOfWinner;
    }

    /**
     * Set dateStart
     *
     * @param \DateTime $dateStart
     * @return Quizz
     */
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    /**
     * Get dateStart
     *
     * @return \DateTime 
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * Set dateEnd
     *
     * @param \DateTime $dateEnd
     * @return Quizz
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return \DateTime 
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Quizz
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
}
