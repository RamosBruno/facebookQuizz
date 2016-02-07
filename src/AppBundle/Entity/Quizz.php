<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    protected $active;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $nbQuestion;

    /**
    * @var \DateTime
    *
    * @ORM\Column(type="datetime", nullable=true)
    */
    protected $countdown;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Rule", inversedBy="quizz")
     * @ORM\JoinColumn(nullable=false)
     */
    private $rule;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Question", mappedBy="quizz", cascade={"persist"})
     */
    private $questions;

    /**
    * @ORM\OneToMany(targetEntity="AppBundle\Entity\QuizzParticipation", mappedBy="quizz")
    */
    private $quizzParticipation;

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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->questions = new ArrayCollection();
    }

    /**
     * Add questions
     *
     * @param \AppBundle\Entity\Question $questions
     * @return Quizz
     */
    public function addQuestion(Question $questions)
    {
        $this->questions[] = $questions;

        return $this;
    }

    /**
     * Remove questions
     *
     * @param \AppBundle\Entity\Question $questions
     */
    public function removeQuestion(Question $questions)
    {
        $this->questions->removeElement($questions);
    }

    /**
     * Get questions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Quizz
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set rule
     *
     * @param \AppBundle\Entity\Rule $rule
     * @return Quizz
     */
    public function setRule(Rule $rule)
    {
        $this->rule = $rule;

        return $this;
    }

    /**
     * Get rule
     *
     * @return \AppBundle\Entity\Rule
     */
    public function getRule()
    {
        return $this->rule;
    }

    /**
     * Set nbQuestion
     *
     * @param integer $nbQuestion
     * @return Quizz
     */
    public function setNbQuestion($nbQuestion)
    {
        $this->nbQuestion = $nbQuestion;

        return $this;
    }

    /**
     * Get nbQuestion
     *
     * @return integer
     */
    public function getNbQuestion()
    {
        return $this->nbQuestion;
    }

    /**
     * Set the value of Countdown
     *
     * @param \DateTime countdown
     * @return QUizz
     */
    public function setCountdown(\DateTime $countdown)
    {
        $this->countdown = $countdown;

        return $this;
    }

    /**
     * Get the value of Countdown
     *
     * @return \DateTime
     */
    public function getCountdown()
    {
        return $this->countdown;
    }

    /**
     * @return mixed
     */
    public function getQuizzParticipation()
    {
        return $this->quizzParticipation;
    }

    /**
     * @param mixed $quizzParticipation
     * @return Quizz
     */
    public function setQuizzParticipation($quizzParticipation)
    {
        $this->quizzParticipation = $quizzParticipation;

        return $this;
    }



}
