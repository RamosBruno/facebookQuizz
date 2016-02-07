<?php
namespace AppBundle\Controller\Front;

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
    public function indexAction(Request $request, $id) {

        $em = $this->getDoctrine()->getManager();
        $quizz = $em->getRepository('AppBundle:Quizz')->findOneBy(["active" => true]);
        $questions = $quizz->getQuestions();
        $participationList = [];
        $score = 0;
        $i = 0;
        $maxQuestions = sizeof($questions);

        $quizzParticipation = $em->getRepository('AppBundle:QuizzParticipation')->findBy(["quizz" => $quizz->getId()], ["dataUserFacebook" => "asc"]);
        foreach ($quizzParticipation as $participation) {

            if ($i < $maxQuestions) {
                $score += (int) $participation->getValid();
                $i++;
            } else {
                $participationList[$participant] = $score;
                $score = 0;
                $i = 0;
            }
            $participant = $participation->getDataUserFacebook()->getProfilName();
        }
        arsort($participationList);

        return $this->render('Front/Quizz/index.html.twig', [
            'quizz'=> $quizz,
            'participationList' => $participationList
        ]);
    }

    /**
    * @Route("/{id}/question/{id_question}", name="front_question")
    * @Method({"GET", "POST"})
    */
    public function showQuizzAction(Request $request, $id_question = 0, $score = 0) {

        static $nbQuestion = 0;

        $em = $this->getDoctrine()->getManager();
        $quizz = $em->getRepository('AppBundle:Quizz')->findOneBy(["active" => true]);
        $questions = $quizz->getQuestions();


        if ($nbQuestion < $quizz->getNbQuestion()) {
            $actualQuestion = $questions[$id_question];
            $rightResponse = $actualQuestion->getResponseValide();
            $nbQuestion++;
        } else {
            $nbQuestion = 0;
            return $this->render('Front/Quizz/end.html.twig', [
                'score' => $score
            ]);
        }

        return $this->render('Front/Quizz/quizz.html.twig', [
            'actualQuizz' => $quizz,
            'actualQuestion' => $actualQuestion,
            'id_question' => $id_question,
            'score' => $score
        ]);
    }

    /**
     * @Route("/{id}/question/{id_question}/reponse_quizz", name="reponse_quizz")
     * @Method({"POST"})
     */
    public function postAnswer(Request $request){

        $em = $this->getDoctrine()->getManager();
        $reponse = $request->get('reponse');
        $quizz_id = $request->get('quizz_id');
        $question_id = $request->get('question_id');
        $participant = $request->get('participant');
        $score = $request->get('score');
        $countdown = $request->get('countdown');

        $quizz_participation = new QuizzParticipation();
        $question = $em->getRepository("AppBundle:Question")->find($question_id);
        $quizz = $em->getRepository("AppBundle:Quizz")->find($quizz_id);
        $data_user = $em->getRepository("AppBundle:DataUserFacebook")->find($participant);
        $quizz_participation->setQuestion($question);
        $quizz_participation->setQuizz($quizz);
        $quizz_participation->setDataUserFacebook($data_user);
        $quizz_participation->setDate(new \DateTime());
        $quizz_participation->setCountdown(new \DateTime("00:" . $countdown));

        $reponse_valide = $question->getResponseValide();
        if($reponse_valide == $reponse){
            $quizz_participation->setValid(1);
            $score++;
        }else{
            $quizz_participation->setValid(0);
        }
        $em->persist($quizz_participation);
        $em->flush();

        return $this->forward('AppBundle:Front\Quizz:showQuizz', ["id" => $quizz_id, "question_id" => $question_id + 1, "score" => $score]);
    }

}
