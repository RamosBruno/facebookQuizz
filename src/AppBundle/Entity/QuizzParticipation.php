<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\QuizzParticipationRepository")
 */
class QuizzParticipation
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    protected $valid;

    /**
     * @var \datetime
     *
     * @ORM\Column(type="datetime")
     */
    protected $date;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\DataUserFacebook", inversedBy="quizzParticipation")
     * @ORM\JoinColumn(nullable=false)
     */
    private $dataUserFacebook;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Quizz", inversedBy="quizzParticipation")
     * @ORM\JoinColumn(nullable=false)
     */
    private $quizz;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Question", inversedBy="quizzParticipation")
     * @ORM\JoinColumn(nullable=false)
     */
    private $question;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $countdown;

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
     * Set valid
     *
     * @param boolean $valid
     * @return QuizzParticipation
     */
    public function setValid($valid)
    {
        $this->valid = $valid;

        return $this;
    }

    /**
     * Get valid
     *
     * @return boolean
     */
    public function getValid()
    {
        return $this->valid;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return QuizzParticipation
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set dataUserFacebook
     *
     * @param \AppBundle\Entity\DataUserFacebook $dataUserFacebook
     * @return QuizzParticipation
     */
    public function setDataUserFacebook(DataUserFacebook $dataUserFacebook)
    {
        $this->dataUserFacebook = $dataUserFacebook;

        return $this;
    }

    /**
     * Get dataUserFacebook
     *
     * @return \AppBundle\Entity\DataUserFacebook
     */
    public function getDataUserFacebook()
    {
        return $this->dataUserFacebook;
    }

    /**
     * Set question
     *
     * @param \AppBundle\Entity\Question $question
     * @return QuizzParticipation
     */
    public function setQuestion(Question $question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return \AppBundle\Entity\Question
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set quizz
     *
     * @param \AppBundle\Entity\Quizz $quizz
     * @return QuizzParticipation
     */
    public function setQuizz(Quizz $quizz)
    {
        $this->quizz = $quizz;

        return $this;
    }

    /**
     * Get quizz
     *
     * @return \AppBundle\Entity\Quizz
     */
    public function getQuizz()
    {
        return $this->quizz;
    }

    /**
     * @return \DateTime
     */
    public function getCountdown()
    {
        return $this->countdown;
    }

    /**
     * @param \DateTime $countdown
     * @return  QuizzParticipation
     */
    public function setCountdown($countdown)
    {
        $this->countdown = $countdown;

        return $this;
    }


}
