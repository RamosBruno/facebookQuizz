<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\QuestionRepository")
 */
class Question
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
     * @ORM\Column(type="text")
     */
    protected $question;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $response1;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $response2;

    /**
    * @ORM\OneToMany(targetEntity="AppBundle\Entity\QuizzParticipation", mappedBy="question", cascade={"remove"})
    */
    private $quizzParticipation;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $response3;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $response4;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $responseValide;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Quizz", inversedBy="questions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $quizz;

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
     * Set question
     *
     * @param string $question
     * @return Question
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set quizz
     *
     * @param \AppBundle\Entity\Quizz $quizz
     * @return Question
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
     * Set response1
     *
     * @param string $response1
     * @return Question
     */
    public function setResponse1($response1)
    {
        $this->response1 = $response1;

        return $this;
    }

    /**
     * Get response1
     *
     * @return string
     */
    public function getResponse1()
    {
        return $this->response1;
    }

    /**
     * Set response2
     *
     * @param string $response2
     * @return Question
     */
    public function setResponse2($response2)
    {
        $this->response2 = $response2;

        return $this;
    }

    /**
     * Get response2
     *
     * @return string
     */
    public function getResponse2()
    {
        return $this->response2;
    }

    /**
     * Set response3
     *
     * @param string $response3
     * @return Question
     */
    public function setResponse3($response3)
    {
        $this->response3 = $response3;

        return $this;
    }

    /**
     * Get response3
     *
     * @return string
     */
    public function getResponse3()
    {
        return $this->response3;
    }

    /**
     * Set response4
     *
     * @param string $response4
     * @return Question
     */
    public function setResponse4($response4)
    {
        $this->response4 = $response4;

        return $this;
    }

    /**
     * Get response4
     *
     * @return string
     */
    public function getResponse4()
    {
        return $this->response4;
    }

    /**
     * Set responseValide
     *
     * @param integer $responseValide
     * @return Question
     */
    public function setResponseValide($responseValide)
    {
        $this->responseValide = $responseValide;

        return $this;
    }

    /**
     * Get responseValide
     *
     * @return integer
     */
    public function getResponseValide()
    {
        return $this->responseValide;
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
     * @return Question
     */
    public function setQuizzParticipation($quizzParticipation)
    {
        $this->quizzParticipation = $quizzParticipation;

        return $this;
    }


}
