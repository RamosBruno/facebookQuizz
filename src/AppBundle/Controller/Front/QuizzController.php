<?php
namespace AppBundle\Controller\Front;

use AppBundle\Entity\DataUserFacebook;
use AppBundle\Entity\Question;
use AppBundle\Entity\QuizzParticipation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


/**
* @Route("/quizz")
*/
class QuizzController extends Controller {

    /**
    * @Route("/{id}", name="front_quizz")
    * @Method({"GET", "POST"})
    */
    public function indexAction() {

        $em = $this->getDoctrine()->getManager();
        $quizz = $em->getRepository('AppBundle:Quizz')->findOneBy(["active" => true]);

        return $this->render('Front/Quizz/index.html.twig', [
            'quizz'=> $quizz
        ]);
    }

    /**
    * @Route("/{id}/question/{id_question}", name="front_question")
    * @Method({"GET", "POST"})
     *
     * @param  integer $id_question
     * @param integer $score
     * @param integer $num_question
     *
     * @return  $this
    */
    public function showQuizzAction($id_question = 0, $score = 0, $num_question = 0) {

        $em = $this->getDoctrine()->getManager();
        $quizz = $em->getRepository('AppBundle:Quizz')->findOneBy(["active" => true]);
        $questions = $quizz->getQuestions();
        $participant = $this->get('session')->get('user_id');

        if ($num_question < $quizz->getNbQuestion()) {
            $actualQuestion = $questions[$id_question];
        } else {
            /**
             * TODO : corriger erreur sur les  notifications
             */
            $this->get('facebook')->sendNotifications($participant, $quizz->getName());
            return $this->render('Front/Quizz/end.html.twig', [
                'score' => $score
            ]);
        }

        return $this->render('Front/Quizz/quizz.html.twig', [
            'actualQuizz' => $quizz,
            'actualQuestion' => $actualQuestion,
            'id_question' => $id_question,
            'num_question' => $num_question,
            'score' => $score,
            'participant' => $participant
        ]);
    }

    /**
     * @param $data_user DataUserFacebook
     * @param $question Question
     *
     * @return integer
     */
    public function generateShuffleQuestion($data_user, $question){
        $em = $this->getDoctrine()->getManager();
        $quizz_id = $question->getQuizz()->getId();

        $tab_id = $em->getRepository('AppBundle:Question')->findBy(['quizz' =>  $quizz_id] );

        $question_id = intval(array_rand($tab_id, 1));
        if ($em->getRepository('AppBundle:QuizzParticipation')->getAnswerByUser($data_user->getId(),$tab_id[$question_id],$quizz_id)){
            return $question_id;
        }
        else{
            return $this->generateShuffleQuestion($data_user, $question);
        }

    }

    /**
     * @Route("/{id}/question/{id_question}/reponse_quizz", name="reponse_quizz")
     * @Method({"POST"})
     * @param Request $request
     * @return $this
     */
    public function postAnswer(Request $request){

        $em = $this->getDoctrine()->getManager();
        $answer = $request->get('answer');
        $quizz_id = $request->get('quizz_id');
        $question_id = $request->get('question_id');
        $participant = $request->get('participant');
        $score = $request->get('score');
        $countdown = $request->get('countdown');
        $num_question = $request->get('num_question');

        $quizz_participation = new QuizzParticipation();
        $question = $em->getRepository("AppBundle:Question")->find($question_id);
        $quizz = $em->getRepository("AppBundle:Quizz")->find($quizz_id);
        $data_user = $em->getRepository("AppBundle:DataUserFacebook")->find($participant);
        $quizz_participation->setQuestion($question);
        $quizz_participation->setQuizz($quizz);
        $quizz_participation->setDataUserFacebook($data_user);
        $quizz_participation->setDate(new \DateTime());
        $quizz_participation->setCountdown(\DateTime::createFromFormat('s', $countdown));

        if (empty($em->getRepository("AppBundle:QuizzParticipation")->findOneBy(['question' => $question->getId(),
            'dataUserFacebook' => $data_user->getId()]))){

            $reponse_valide = $question->getResponseValide();
            if ($reponse_valide == $answer){
                $quizz_participation->setValid(1);
                $score++;
            }else{
                $quizz_participation->setValid(0);
            }
            $em->persist($quizz_participation);
            $em->flush();
        }
        else{
            $this->generateShuffleQuestion($data_user,$question);
        }

        return $this->showQuizzAction($this->generateShuffleQuestion($data_user,$question), $score, $num_question);
    }

}
