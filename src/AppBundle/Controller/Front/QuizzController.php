<?php
namespace AppBundle\Controller\Front;

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
        $quizz = $em->getRepository('AppBundle:Quizz')->find($id);

        return $this->render('Front/Quizz/index.html.twig', [
            'quizz'=> $quizz
        ]);
    }

    /**
    * @Route("/{id}/question/{id_question}", name="front_question")
    * @Method({"GET", "POST"})
    */
    public function showQuizz(Request $request, $id, $id_question = 0, $response = null, $score = 0) {

        $em = $this->getDoctrine()->getManager();
        $quizz = $em->getRepository('AppBundle:Quizz')->find($id);
        $questions = $quizz->getQuestions();
        
        $participationList = [];
        $score_participation = 0;
        $i = 0;
        $rank = 0;
        $maxQuestions = sizeof($questions);

        //A remplacer par la liste d'amis du mec, a voir si faisable
        // On ne peut afficher que la liste d'amis qui ont l'application, et faut demander une permission supplémentaire
        $quizzParticipation = $em->getRepository('AppBundle:QuizzParticipation')->findBy(["quizz" => $quizz->getId()], ["dataUserFacebook" => "asc"]);
        
        foreach ($quizzParticipation as $participation) {
                
            if ($i < $maxQuestions) {
                $score_participation += (int) $participation->getValid();
                $i++;
            } else {
                $participationList[$participant]['score'] = $score_participation;
                $participationList[$participant]['picture'] = $participant_pic;
                $score_participation = 0;
                $i = 0;
            }
            $participant = $participation->getDataUserFacebook()->getProfilName();
            $participant_pic = $participation->getDataUserFacebook()->getPictureProfilUrl();
        }
        arsort($participationList);
        /*
        
        En attente de la session, permettra d'afficher le classement approximatif du joueur
        $i = 1;
        foreach($participationList as $participant => $score)
        {
            if($_SESSION['name'] == $participant && $score>0)
            {
                $rank = $i;
                break;
            }
            $i++;
        }
        */
        
        //Décommenter la ligne du dessous pour atterir directement sur la page finale
       //$id_question = sizeof($questions);
        if ($id_question < sizeof($questions)) {
            $actualQuestion = $questions[$id_question];
            $rightResponse = $actualQuestion->getResponseValide();
            if (!empty($response) && $response == $rightResponse) {
                $score++;
            }

        } else {
            return $this->render('Front/Quizz/end.html.twig', [
                'score' => $score,
                'rank' => $rank,
                'quizz' => $quizz,
                'participationList' => $participationList
            ]);
        }

        return $this->render('Front/Quizz/quizz.html.twig', [
            'actualQuizz' => $quizz,
            'actualQuestion' => $actualQuestion,
            'id_question' => $id_question,
            'score' => $score
        ]);
    }

}
